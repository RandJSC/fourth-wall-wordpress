<?php
/*
Title: Images
Setting: fwe_settings
*/

piklist('field', array(
  'type'        => 'file',
  'field'       => 'admin_logo',
  'label'       => 'Login Page Logo',
  'description' => 'Square PNG (max dimensions 200x200)',
  'help'        => 'This logo is displayed above the admin login form',
  'attributes'  => array(
    'class' => 'text'
  ),
));

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

piklist('field', array(
  'type'        => 'file',
  'field'       => 'default_category_banner',
  'label'       => 'Default Category Banner',
  'description' => 'If a category has no banner image, this one will be used.',
  'attributes'  => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'        => 'file',
  'field'       => 'search_banner',
  'label'       => 'Search Results Banner',
  'description' => 'Shown on all search result listings',
  'attributes'  => array(
    'class' => 'text',
  )
));
?>
