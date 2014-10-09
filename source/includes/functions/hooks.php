<?php
/**
 * Fourth Wall Events
 * Post Save Hooks
 */

function fwe_update_location($post_id) {
  if (!array_key_exists('post_type', $_POST) || $_POST['post_type'] !== 'location') return;
}
add_action('save_post', 'fwe_update_location');
?>
