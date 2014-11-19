<?php
/*
Title: Location
Post Type: gallery, case_study
Context: normal
*/

piklist('field', array(
  'type'        => 'date',
  'field'       => 'event_date',
  'label'       => 'Event Date',
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'location_name',
  'label'      => 'Location Name',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'longitude',
  'label' => 'Longitude',
  'help'  => 'If left blank, this item will not appear on the map',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'latitude',
  'label' => 'Latitude',
  'help'  => 'If left blank, this item will not appear on the map',
));
?>
