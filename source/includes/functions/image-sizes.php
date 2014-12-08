<?php
/**
 * Fourth Wall Events
 * Image Size Definitions
 */

function fwe_image_sizes() {
  add_theme_support('post-thumbnails');

  // [todo] - define image sizes here
  // set_post_thumbnail_size($width, $height, $crop);
  // add_image_size($name, $width, $height, $crop);

  add_image_size('tiny-thumb', 162, 128, true);
  add_image_size('team-member-headshot', 275, 275, true);
  add_image_size('team-member-thumb', 200, 200, true);
  add_image_size('homepage-slider', 1856, 720, true);
}
add_action('init', 'fwe_image_sizes');

?>
