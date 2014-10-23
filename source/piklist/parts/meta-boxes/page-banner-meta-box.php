<?php
/*
Title: Page Banner
Post Type: page
Context: side
Priority: high
*/

piklist('field', array(
  'type'  => 'file',
  'field' => 'banner_image',
  'label' => 'Banner Image',
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'banner_caption',
  'label'      => 'Banner Caption',
  'attributes' => array(
    'class' => 'text',
  )
));
?>
