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
