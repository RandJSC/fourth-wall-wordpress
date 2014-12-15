<?php
/**
 * Fourth Wall Events
 * Post Archive Template
 */

get_header();

global $wp_query, $fwe_settings;

$banner  = $fwe_settings['default_category_banner'];
$banner  = wp_get_attachment_image_src($banner, 'full');
$caption = "What's New";
?>

<?php if ($banner): ?>
  <?php include(locate_template('partials/generic-banner.php')); ?>
<?php endif; ?>

<?php include(locate_template('partials/post-quick-links.php')); ?>

<section id="main-page-content" class="content-section padded">
  <div class="page-header">
    <h1>Archive</h1>
    <hr>
  </div>

  <?php include(locate_template('partials/post-results.php')); ?>
</section>

<?php
fwe_pagination_links();
get_footer();
?>
