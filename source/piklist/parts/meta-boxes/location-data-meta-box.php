<?php
/*
Title: Location Data
Post Type: location
Context: normal
*/

piklist('field', array(
  'type'  => 'text',
  'field' => 'latitude',
  'label' => 'Latitude',
  'hint'  => 'If left blank, this location will not appear on the Map page',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'longitude',
  'label' => 'longitude',
  'hint'  => 'If left blank, this location will not appear on the Map page',
));

?>
