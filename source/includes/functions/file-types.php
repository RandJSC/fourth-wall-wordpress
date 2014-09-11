<?php
/**
 * Fourth Wall Events
 * Allowable Upload MIME Types
 */

function fwe_add_custom_mime_types($existing_mimes = array()) {
  $existing_mimes['svg'] = 'image/svg+xml';

  return $existing_mimes;
}
add_filter('upload_mimes', 'fwe_add_custom_mime_types');
?>
