<?php
/**
 * Fourth Wall Events
 * Post Save Hooks
 */

function fwe_team_member_set_surname($post_id) {
  if (wp_is_post_revision($post_id)) return;
  if ($_POST['post_type'] !== 'team_member') return;

  $surname = get_post_meta($post_id, 'surname', true);

  if (!$surname) {
    $surname = fwe_get_surname($_POST['post_title']);
    update_post_meta($post_id, 'surname', $surname);
  }
}
add_action('save_post', 'fwe_team_member_set_surname');

?>
