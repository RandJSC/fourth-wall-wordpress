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
}
add_action('init', 'fwe_image_sizes');

?>
