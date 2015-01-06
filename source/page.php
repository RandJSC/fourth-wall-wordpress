<?php
get_header();

global $post, $fwe_settings;

$banner = fwe_get_page_banner($post->ID);
?>

<?php include(locate_template('partials/subpage-banner.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  // Fetch the pages whose stitch_content should be pulled into this one:
  $post_id       = get_the_ID();
  $stitches      = get_post_meta($post_id, 'stitch_children');
  $stitches      = array_filter($stitches, function($item) {
    return !empty($item);
  });
  $has_stitches  = is_array($stitches) && count($stitches);
  $slider_images = get_post_meta($post_id, 'slider_images', true);
  $has_slides    = !empty($slider_images) && !empty($slider_images['image'][0][0]);
  ?>

  <?php // This page's content: ?>
  <?php include(locate_template('partials/subpage-main-content.php')); ?>

  <?php
  // Stitched subpage content (if any):

  if ($has_stitches):
    foreach ($stitches as $stitch_id) {
      $stitch = fwe_get_stitch_vars($stitch_id);
      include(locate_template('partials/subpage-stitch-content.php'));
    }
    wp_reset_postdata();
  endif;
  ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
