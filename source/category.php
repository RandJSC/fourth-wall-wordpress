<?php
/**
 * Fourth Wall Events
 * Category Archive Template
 */

get_header();

global $wp_query, $fwe_settings;

$banner   = $fwe_settings['default_category_banner'];
$banner   = wp_get_attachment_image_src($banner, 'full');
$caption  = "What's New";
$category = $wp_query->queried_object;
?>

<?php if ($banner): ?>
  <?php include(locate_template('partials/generic-banner.php')); ?>
<?php endif; ?>

<?php include(locate_template('partials/post-quick-links.php')); ?>

<section id="main-page-content" class="content-section padded archive">
  <div class="page-header">
    <h1>
      <?php echo apply_filters('the_title', $category->name); ?>
    </h1>
    <hr>
  </div>

  <?php if ($category->description): ?>
    <div class="archive-intro">
      <?php echo apply_filters('the_content', $category->description); ?>
    </div>
  <?php endif; ?>

  <?php include(locate_template('partials/post-results.php')); ?>
</section>

<?php
fwe_pagination_links();
get_footer();
?>
