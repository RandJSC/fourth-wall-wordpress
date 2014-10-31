<?php
/*
Title: Stitch Content
Post Type: page
Context: normal
Priority: high
*/

piklist('field', array(
  'type'    => 'radio',
  'field'   => 'pad_header',
  'label'   => 'Add Padding to Header?',
  'choices' => array(
    'yes' => 'Yes',
    'no'  => 'No',
  ),
  'value'   => 'yes',
));

piklist('field', array(
  'type'    => 'radio',
  'field'   => 'pad_content',
  'label'   => 'Add Padding to Content?',
  'choices' => array(
    'yes' => 'Yes',
    'no'  => 'No',
  ),
  'value'   => 'yes',
));

piklist('field', array(
  'type' => 'editor',
  'field' => 'stitch_content',
  'label' => 'Stitch Content',
  'help' => 'This content will be displayed when this page is pulled into another page via stitching',
  'drag_drop_upload' => true,
));
?>
