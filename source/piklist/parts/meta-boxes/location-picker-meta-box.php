<?php
/*
Title: Location
Post Type: gallery, case_study
Context: normal
*/

$locations     = get_posts(array(
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'post_type'      => 'location',
  'orderby'        => 'title',
  'order'          => 'ASC',
));
$loc_msg       = empty($locations) ? 'Please add some locations!' : '-- Select a Location --';
$location_opts = array( '' => $loc_msg );

foreach ($locations as $loc) {
  $location_opts[$loc->post_name] = $loc->post_title;
}

piklist('field', array(
  'type'        => 'date',
  'field'       => 'event_date',
  'label'       => 'Event Date',
));

piklist('field', array(
  'type'    => 'checkbox',
  'field'   => 'location_id',
  'label'   => 'Location',
  'choices' => $location_opts,
));
?>
