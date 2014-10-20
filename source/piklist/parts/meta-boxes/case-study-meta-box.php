<?php
/*
Title: Case Study
Post Type: case_study
Context: normal
Priority: high
*/

$galleries = get_posts(array(
  'post_type'      => 'gallery',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'name',
  'order'          => 'ASC',
));
$gallery_choices = array('' => '-- Select a Gallery --');

foreach ($galleries as $gallery) {
  $gallery_choices[$gallery->ID] = $gallery->post_title;
}

piklist('field', array(
  'type'    => 'select',
  'field'   => 'gallery_id',
  'label'   => 'Event Photo Gallery',
  'help'    => 'Photos from this gallery will be shown in a slider on the case study',
  'choices' => $gallery_choices,
));
?>
