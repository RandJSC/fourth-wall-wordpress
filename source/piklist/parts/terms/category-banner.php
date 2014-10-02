<?php
/*
Title: Category Customization
Description: Extra fields for built-in categories
Taxonomy: category
New: true
*/

piklist('field', array(
  'type'        => 'file',
  'field'       => 'banner_image',
  'label'       => 'Banner Image',
  'description' => 'This will be shown at the top of all pages w/ posts belonging to this category.',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'banner_caption',
  'label'       => 'Banner Caption',
  'description' => 'If blank, the site will use the name of the category.',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'banner_link',
  'label'       => 'Banner Link',
  'description' => 'Optional. If blank, the banner image will not be clickable.',
));
?>
