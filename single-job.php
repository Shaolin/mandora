<?php get_header(); ?>

<?php
  $company = get_field('company_name');
  $location = get_field('location');
  $salary = get_field('salary');
  $type = get_field('job_type');
  $apply = get_field('application_link');

  // Fix missing https issue
  if ($apply && !preg_match("~^(?:f|ht)tps?://~i", $apply)) {
      $apply = "https://" . $apply;
  }
?>

<section class="single-job">

  <h1><?php the_title(); ?></h1>

  <?php if($company): ?>
    <p class="company"><strong><?php echo esc_html($company); ?></strong></p>
  <?php endif; ?>

  <p class="job-meta">
    <?php if($location): ?> 📍 <?php echo esc_html($location); ?> <?php endif; ?>
    <?php if($type): ?> | 💼 <?php echo esc_html($type); ?> <?php endif; ?>
    <?php if($salary): ?> | 💰 <?php echo esc_html($salary); ?> <?php endif; ?>
  </p>

  <div class="job-content">
    <?php the_content(); ?>
  </div>

  <?php if($apply): ?>
    <a href="<?php echo esc_url($apply); ?>" class="apply-btn" target="_blank">
      Apply Now
    </a>
  <?php endif; ?>

</section>

<?php get_footer(); ?>