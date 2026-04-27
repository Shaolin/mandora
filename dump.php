<?php



function my_theme_assets() {
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_script('main-js', get_template_directory_uri() . '/script.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'my_theme_assets');


// navigation

function my_theme_setup() {
    register_nav_menus([
        'primary' => 'Primary Menu'
    ]);
}
add_action('after_setup_theme', 'my_theme_setup');


add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('custom-logo');


// Jobs page



function create_jobs_post_type() {

    $labels = array(
        'name' => 'Jobs',
        'singular_name' => 'Job',
        'add_new' => 'Add Job',
        'add_new_item' => 'Add New Job',
        'edit_item' => 'Edit Job',
        'new_item' => 'New Job',
        'view_item' => 'View Job',
        'search_items' => 'Search Jobs',
        'not_found' => 'No jobs found',
        'menu_name' => 'Jobs'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'jobs'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-briefcase',
        'show_in_rest' => true
    );

    register_post_type('job', $args);
}

add_action('init', 'create_jobs_post_type');

// filter

function register_job_taxonomy() {

    register_taxonomy('job_category', 'job', [
        'label' => 'Job Categories',
        'rewrite' => ['slug' => 'job-category'],
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
    ]);

}
add_action('init', 'register_job_taxonomy');

// load more

function load_more_jobs() {

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = [
        'post_type' => 'job',
        'posts_per_page' => 6,
        'paged' => $paged,
        'post_status' => 'publish'
    ];

    if (!empty($search)) {
        $args['s'] = $search;
    }

    if (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'job_category',
                'field'    => 'slug',
                'terms'    => $category,
            ]
        ];
    }

    $jobs = new WP_Query($args);

    if ($jobs->have_posts()) :
        while ($jobs->have_posts()) : $jobs->the_post();

            $company = get_field('company_name');
            $location = get_field('location');
            $salary = get_field('salary');
            $type = get_field('job_type');
            ?>

            <div class="job-card">
                <div class="job-header">
                    <h3><?php the_title(); ?></h3>
                    <span class="badge"><?php echo esc_html($type); ?></span>
                </div>

                <p class="company"><?php echo esc_html($company); ?></p>

                <p class="job-meta">
                    📍 <?php echo esc_html($location); ?> • 💰 <?php echo esc_html($salary); ?>
                </p>

                <div class="job-desc">
                    <?php echo wp_trim_words(get_the_content(), 18); ?>
                </div>

                <a href="<?php the_permalink(); ?>" class="apply-btn">
                    View Details
                </a>
            </div>

            <?php
        endwhile;
    endif;

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_load_more_jobs', 'load_more_jobs');
add_action('wp_ajax_nopriv_load_more_jobs', 'load_more_jobs');

// create applications

function create_applications_post_type() {

    register_post_type('application', [
        'labels' => [
            'name' => 'Applications',
            'singular_name' => 'Application'
        ],
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => ['title'],
    ]);

}
add_action('init', 'create_applications_post_type');

add_action('wpcf7_mail_sent', 'save_application_to_db');

function save_application_to_db($contact_form) {

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) return;

    $data = $submission->get_posted_data();
    $files = $submission->uploaded_files();

    $name = $data['your-name'] ?? '';
    $email = $data['your-email'] ?? '';
    $phone = $data['your-phone'] ?? '';
    $category = $data['your-category'] ?? '';
    $extra = $data['your-message'] ?? '';

    // CV file
    $cv = '';
    if (!empty($files['your-cv'])) {
        $cv = $files['your-cv'];
    }

    // Create application post
    $post_id = wp_insert_post([
        'post_type'   => 'application',
        'post_title'  => $name . ' - ' . $category,
        'post_status' => 'publish'
    ]);

    // Save metadata
    update_post_meta($post_id, 'email', $email);
    update_post_meta($post_id, 'phone', $phone);
    update_post_meta($post_id, 'category', $category);
    update_post_meta($post_id, 'extra', $extra);
    update_post_meta($post_id, 'cv', $cv);

}
if (is_array($category)) {
    $category = implode(', ', $category);
}

// download cv

add_action('wpcf7_mail_sent', 'save_job_application');

function save_job_application($contact_form) {

    $submission = WPCF7_Submission::get_instance();

    if (!$submission) return;

    // Get form data
    $data = $submission->get_posted_data();
    $uploaded_files = $submission->uploaded_files();

    // Get fields
    $name = sanitize_text_field($data['your-name'] ?? '');
    $email = sanitize_email($data['your-email'] ?? '');
    $phone = sanitize_text_field($data['your-phone'] ?? '');
    $category = $data['your-category'] ?? '';

    // FIX ARRAY ISSUE
    if (is_array($category)) {
        $category = implode(', ', $category);
    }

    // Get CV file
    $cv = $uploaded_files['your-cv'] ?? '';

    // Create Application post
    $post_id = wp_insert_post([
        'post_type'   => 'application',
        'post_title'  => $name . ' - ' . $category,
        'post_status' => 'publish'
    ]);

    // Save meta
    if ($post_id) {
        update_post_meta($post_id, 'name', $name);
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'phone', $phone);
        update_post_meta($post_id, 'category', $category);
        update_post_meta($post_id, 'cv', $cv);
    }
}

// header.php
<!DOCTYPE html>
<html>
<head>
    <?php wp_head(); ?>
</head>

<body>


<nav class="main-nav">
  <div class="nav-left">
    <div class="logo">
      <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            bloginfo('name');
        }
      ?>
    </div>
  </div>

  <div class="nav-center">
    <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'items_wrap' => '%3$s',
      ]);
    ?>
  </div>

  <div class="nav-right">
    <button id="open-apply-form" class="apply-btn">Apply For Job</button>
    <div class="toggle" onclick="toggleMode()">🌙</div>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
  </div>
</nav>

<div class="overlay" onclick="toggleMenu()"></div>


<!DOCTYPE html>
<html>
<head>
    <?php wp_head(); ?>
</head>

<body>


<nav class="main-nav">

  <div class="nav-left">
    <div class="logo">
      <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            bloginfo('name');
        }
      ?>
    </div>
  </div>

  <div class="nav-center mobile-menu" id="mobileMenu">
    <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'items_wrap' => '%3$s',
      ]);
    ?>
  </div>
 
  

  <div class="nav-right">
    <button id="open-apply-form" class="apply-btn">Apply For Job</button>
    <div class="toggle" onclick="toggleMode()">🌙</div>

    <!-- hamburger -->
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
   
  </div>

</nav>

<div class="overlay" onclick="toggleMenu()" id="overlay"></div>

