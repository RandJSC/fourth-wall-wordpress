<?php
/*
Title: Slider Images
Post Type: page
Context: normal
Priority: high
*/

piklist('field', array(
  'type'        => 'group',
  'field'       => 'slider_images',
  'label'       => 'Slider Images',
  'description' => 'These images will be shown in a slideshow at the top of the page',
  'add_more'    => true,
  'fields'      => array(
    array(
      'type'  => 'text',
      'field' => 'title',
      'label' => 'Title',
    ),
    array(
      'type' => 'text',
      'field' => 'link_url',
      'label' => 'Link URL',
    ),
    array(
      'type'        => 'file',
      'field'       => 'image',
      'label'       => 'Upload an Image',
      'description' => 'Suggested Dimensions: 1044x522 pixels',
    ),  
  ),
));

?>
