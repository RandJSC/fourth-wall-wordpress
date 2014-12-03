<?php
/*
Template Name: Map Page
*/

get_header();

global $post, $fwe_settings;

$banner      = fwe_get_page_banner($post->ID);
$api_key     = $fwe_settings['google_maps_api_key'];
$enable_zoom = $fwe_settings['map_enable_zoom'] ? 'true' : 'false';
?>

<?php include(locate_template('partials/subpage-banner.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <?php include(locate_template('partials/subpage-main-content.php')); ?>

<?php endwhile; endif; ?>

<section id="event-map">
  <div
    id="map-canvas"
    data-starting-latitude="<?php echo $fwe_settings['map_starting_latitude']; ?>"
    data-starting-longitude="<?php echo $fwe_settings['map_starting_longitude']; ?>"
    data-zoom="<?php echo $fwe_settings['map_zoom_level']; ?>"
    data-enable-zoom="<?php echo $enable_zoom; ?>"></div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>"></script>
<script src="<?php echo $theme_uri; ?>/js/event-map.js"></script>

<?php get_footer(); ?>
