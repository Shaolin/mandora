<?php get_header(); ?>

<section class="jobs-page">
  <h1>Available Jobs</h1>

  <?php
  // GET FILTER VALUES
  $search = isset($_GET['job_search']) ? sanitize_text_field($_GET['job_search']) : '';
  $category = isset($_GET['job_category']) ? sanitize_text_field($_GET['job_category']) : '';
  ?>

  <div class="jobs-toolbar">

    <!-- FILTERS -->
    <div class="job-filters">

     
      <a href="<?php echo get_post_type_archive_link('job'); ?>" class="filter-btn">All</a>

      <a href="?job_category=healthcare<?php echo $search ? '&job_search=' . $search : ''; ?>" class="filter-btn">Healthcare</a>

      <a href="?job_category=hospitality<?php echo $search ? '&job_search=' . $search : ''; ?>" class="filter-btn">Hospitality</a>

      <a href="?job_category=events<?php echo $search ? '&job_search=' . $search : ''; ?>" class="filter-btn">Events</a>

      <a href="?job_category=cleaning<?php echo $search ? '&job_search=' . $search : ''; ?>" class="filter-btn">Cleaning</a>

    </div>

    <!-- SEARCH -->
    <form method="GET" class="job-search">

      <?php if ($category): ?>
        <input type="hidden" name="job_category" value="<?php echo esc_attr($category); ?>">
      <?php endif; ?>

      <input 
        type="text" 
        name="job_search"
        placeholder="Search jobs (e.g. nurse, cleaner...)"
        value="<?php echo esc_attr($search); ?>"
      />

      <button type="submit">Search</button>

    </form>

  </div>

  <?php
  // BUILD QUERY
  $args = [
    'post_type' => 'job',
    'posts_per_page' => 6,
    'post_status' => 'publish'
  ];

  // SEARCH
  if (!empty($search)) {
    $args['s'] = $search;
  }

  // CATEGORY FILTER
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
  ?>

  <div class="jobs-grid">

    <?php if ($jobs->have_posts()) : ?>
      
      <?php while ($jobs->have_posts()) : $jobs->the_post(); ?>

        <?php
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

          <p class="company">
            <?php echo esc_html($company); ?>
          </p>

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

      <?php endwhile; ?>

      <?php wp_reset_postdata(); ?>

    <?php else: ?>

      <p>No job openings found.</p>

    <?php endif; ?>

  </div>

</section>

<div class="load-more-wrap" style="text-align:center; margin-top:30px;">
  <button id="load-more-jobs" class="apply-btn">Load More Jobs</button>
</div>

<script>
  var job_ajax = {
    ajax_url: "<?php echo admin_url('admin-ajax.php'); ?>",
    current_page: 1,
    max_pages: <?php echo $jobs->max_num_pages; ?>,
    search: "<?php echo esc_js($search); ?>",
    category: "<?php echo esc_js($category); ?>"
  };
</script>

<?php get_footer(); ?>