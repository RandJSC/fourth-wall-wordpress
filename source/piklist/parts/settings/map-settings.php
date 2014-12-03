<?php
/*
Title: Map Settings
Setting: fwe_settings
Tab: Map
*/

piklist('field', array(
  'type'  => 'text',
  'field' => 'google_maps_api_key',
  'label' => 'Google Maps API Key',
  'value' => 'AIzaSyBi9BiBeHzphNOXhiyaZTWdUtncrD3afdg',
));

piklist('field', array(
  'type'        => 'number',
  'field'       => 'map_zoom_level',
  'label'       => 'Starting Zoom Level',
  'description' => 'Number between 1 and 13.',
  'value'       => 2,
  'attributes'  => array(
    'min'  => 1,
    'max'  => 13,
    'step' => 1,
  ),
));

piklist('field', array(
  'type'    => 'radio',
  'field'   => 'map_enable_zoom',
  'label'   => 'Enable Zoom Controls?',
  'value'   => 1,
  'choices' => array(
    1 => 'Yes',
    0 => 'No',
  ),
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'map_starting_latitude',
  'label'       => 'Starting Latitude',
  'description' => 'Map will start centered on this point',
  'value'       => '42.3482',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'map_starting_longitude',
  'label'       => 'Starting Longitude',
  'description' => 'Map will start centered on this point',
  'value'       => '-75.1890',
));

?>
