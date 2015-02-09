<?php
/*
Template Name: Map Page
*/

get_header();

global $post, $fwe_settings;

$banner       = fwe_get_page_banner($post->ID);
$api_key      = $fwe_settings['google_maps_api_key'];
$enable_zoom  = $fwe_settings['map_enable_zoom'] ? 'true' : 'false';
$stitches     = array();
$has_slides   = false;
$border_class = 'map';
?>

<?php include(locate_template('partials/subpage-banner.php')); ?>
<?php include(locate_template('partials/gallery-quick-links.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <?php include(locate_template('partials/subpage-main-content.php')); ?>

<?php endwhile; endif; ?>

<section id="event-map">
  <div
    id="map-canvas"
    data-starting-latitude="<?php echo $fwe_settings['map_starting_latitude']; ?>"
    data-starting-longitude="<?php echo $fwe_settings['map_starting_longitude']; ?>"
    data-zoom="<?php echo $fwe_settings['map_zoom_level']; ?>"
    data-enable-zoom="<?php echo $enable_zoom; ?>"
    data-min-zoom="<?php echo $fwe_settings['map_min_zoom']; ?>"
    data-max-zoom="<?php echo $fwe_settings['map_max_zoom']; ?>"
    data-pins-url="<?php echo site_url('/wp-json/fwe/locations'); ?>"></div>
</section>

<section id="location-content">
  <div class="spinner"></div>
  <div class="content"></div>
</section>

<?php include(locate_template('partials/map-location-content-template.php')); ?>
<?php include(locate_template('partials/map-content-item-template.php')); ?>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>"></script>
<script src="<?php echo $theme_uri; ?>/js/event-map.js"></script>

<?php get_footer(); ?>
