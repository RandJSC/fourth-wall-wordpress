<?php
/*
Title: Icon Settings
Setting: fwe_settings
*/

piklist('field', array(
  'type'        => 'file',
  'field'       => 'favicon_ico',
  'label'       => 'Bookmark Icon (ico format)',
  'description' => 'ICO file with 16x16px and 32x32px sizes recommended',
  'help'        => 'This icon is used by older versions of Internet Explorer',
  'attributes'  => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'        => 'file',
  'field'       => 'favicon_png',
  'label'       => 'Bookmark Icon (small PNG)',
  'description' => '32x32px PNG recommended',
  'help'        => 'This icon is used in the address bar of all modern browsers',
  'attributes'  => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'        => 'file',
  'field'       => 'apple_touch_icon',
  'label'       => 'Apple Touch Icon',
  'description' => '152x152px PNG recommended',
  'help'        => 'Displayed when a visitor saves your site to their home screen',
  'attributes'  => array(
    'class' => 'text',
  ),
));
?>