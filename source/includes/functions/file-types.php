<?php
/**
 * Fourth Wall Events
 * Allowable Upload MIME Types
 */

function fwe_add_custom_mime_types($mimes = array()) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'fwe_add_custom_mime_types');

?>
