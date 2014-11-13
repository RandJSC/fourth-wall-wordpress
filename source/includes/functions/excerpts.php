<?php
/**
 * Fourth Wall Events
 * Post Excerpt Configuration
 */

function fwe_excerpt_length($length) {
  return 15;
}
add_filter('excerpt_length', 'fwe_excerpt_length', 999);

function fwe_excerpt_more($more) {
  /*
  global $post;
  $link = get_permalink($post->ID);
  return '&hellip;&nbsp;<a href="' . $link . '">Read More &raquo;</a>';
  */
  return '&hellip;';
}
add_filter('excerpt_more', 'fwe_excerpt_more');

?>
