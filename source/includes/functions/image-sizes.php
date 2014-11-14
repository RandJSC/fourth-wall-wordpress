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

  add_image_size('tiny-thumb', 95, 75, true);
  add_image_size('team-member-headshot', 192, 192, true);
  add_image_size('team-member-thumb', 124, 124, true);
  add_image_size('homepage-slider', 1856, 720, true);
}
add_action('init', 'fwe_image_sizes');

?>
