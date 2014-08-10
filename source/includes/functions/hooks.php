<?php
/**
 * Fourth Wall Events
 * Post Save Hooks
 */

function fwe_update_location($post_id) {
  if ($_POST['post_type'] !== 'location') return;
}
add_action('save_post', 'fwe_update_location');
?>
