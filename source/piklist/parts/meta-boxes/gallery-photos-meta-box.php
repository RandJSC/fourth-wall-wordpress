<?php
/*
Title: Gallery
Post Type: gallery
Context: normal
Priority: high
*/

$case_studies = get_posts(array(
  'post_type'      => 'case_study',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'name',
  'order'          => 'ASC',
));
$case_study_choices = array('' => '-- Select a Case Study --');

foreach ($case_studies as $case_study) {
  $case_study_choices[$case_study->ID] = $case_study->post_title;
}

piklist('field', array(
  'type'        => 'date',
  'field'       => 'event_date',
  'label'       => 'Event Date',
));

piklist('field', array(
  'type'    => 'select',
  'field'   => 'case_study_id',
  'label'   => 'Case Study',
  'choices' => $case_study_choices,
));

piklist('field', array(
  'type' => 'group',
  'field' => 'gallery_photos',
  'label' => 'Photos',
  'add_more' => true,
  'fields' => array(
    array(
      'type' => 'text',
      'field' => 'title',
      'label' => 'Title',
    ),
    array(
      'type' => 'file',
      'field' => 'photo',
      'label' => 'Photo',
    ),
  )
));
?>
