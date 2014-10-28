<?php
/*
Template Name: Map Page
*/

get_header();

global $post, $fwe_settings, $banner;

$banner = fwe_get_page_banner($post->ID);
?>

<?php get_template_part('subpage', 'banner'); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <?php get_template_part('subpage', 'main-content'); ?>

<?php endwhile; endif; ?>

<section id="event-map">
  <div id="map-canvas"></div>
</section>

<script src="<?php echo $theme_uri; ?>/js/event-map.js"></script>

<?php get_footer(); ?>
