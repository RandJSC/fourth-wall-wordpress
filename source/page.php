<?php
get_header();

global $post, $fwe_settings, $banner;

$banner = fwe_get_page_banner($post->ID);
?>

<?php get_template_part('partials/subpage', 'banner'); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  // Fetch the pages whose stitch_content should be pulled into this one:
  $post_id  = get_the_ID();
  $stitches = get_post_meta($post_id, 'stitch_children');
  $stitches = array_filter($stitches, function($item) {
    return !empty($item);
  });
  ?>

  <?php // This page's content: ?>
  <?php get_template_part('partials/subpage', 'main-content'); ?>

  <?php
  // Stitched subpage content (if any):

  if (is_array($stitches) && count($stitches)):
    foreach ($stitches as $stitch_id) {
      $stitch = fwe_get_stitch_vars($stitch_id);
      include(locate_template('partials/subpage-stitch-content.php'));
    }
    wp_reset_postdata();
  endif;
  ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
