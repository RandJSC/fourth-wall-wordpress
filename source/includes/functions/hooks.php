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

function fwe_gallery_case_study_association($post_id) {
  if (wp_is_post_revision($post_id)) return;
  if ($_POST['post_type'] !== 'gallery' || $_POST['post_type'] !== 'case_study') return;

  if ($_POST['post_type'] === 'gallery') {
    $case_study_id = get_post_meta($post_id, 'case_study_id', true);

    if (!$case_study_id) return;

    update_post_meta($case_study_id, 'gallery_id', $post_id);
  } else {
    $gallery_id = get_post_meta($post_id, 'gallery_id', true);

    if (!$gallery_id) return;

    update_post_meta($gallery_id, 'case_study_id', $post_id);
  }
}
add_action('save_post', 'fwe_gallery_case_study_association');

?>
