<?php
/*
Title: Location Fields
Post Type: location
Context: normal
Priority: high
*/

piklist('field', array(
  'type'       => 'text',
  'field'      => 'latitude',
  'label'      => 'Latitude',
  'scope'      => 'post_meta',
  'help'       => 'This is usually set automatically via the address, but sometimes you may need to set it manually.',
  'description' => 'Leave blank to auto-fill.',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'longitude',
  'label'       => 'Longitude',
  'scope'       => 'post_meta',
  'help'        => 'This is usually set automatically via the address, but sometimes you may need to set it manually.',
  'description' => 'Leave blank to auto-fill.',
  'attributes'  => array(
    'class' => 'text',
  ),
));
?>
