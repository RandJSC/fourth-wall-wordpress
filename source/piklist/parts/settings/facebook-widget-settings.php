<?php
/*
Title: Facebook Widget Settings
Setting: fwe_settings
Tab: Facebook Widget
*/

piklist('field', array(
  'type'        => 'text',
  'field'       => 'facebook_page_url',
  'label'       => 'Facebook Page URL',
  'description' => 'The URL of your business\'s Facebook page',
));

piklist('field', array(
  'type' => 'text',
  'field' => 'facebook_widget_width',
  'label' => 'Widget Width',
  'validate' => array(
    array(
      'type' => 'range',
      'options' => array(
        'min' => 300,
        'max' => 600,
      ),
    ),
  ),
));

piklist('field', array(
  'type' => 'text',
  'field' => 'facebook_widget_height',
  'label' => 'Widget Height',
  'validate' => array(
    array(
      'type' => 'range',
      'options' => array(
        'min' => 300,
        'max' => 800,
      ),
    ),
  ),
));
?>
