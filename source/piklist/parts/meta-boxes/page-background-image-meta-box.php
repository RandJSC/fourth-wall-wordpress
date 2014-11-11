<?php
/*
Title: Page Background
Post Type: page
Context: normal
Priority: high
*/

piklist('field', array(
  'type'        => 'file',
  'field'       => 'background_image',
  'scope'       => 'post_meta',
  'label'       => 'Background Image',
  'description' => 'This image will be used as the page\'s background, stretched to fill the width of the user\'s screen. For best results, use an SVG.',
  'validate'    => array(
    array(
      'type'    => 'limit',
      'options' => array(
        'min' => 0,
        'max' => 1,
      ),
    ),
  ),
));

piklist('field', array(
  'type'        => 'color',
  'field'       => 'background_color',
  'scope'       => 'post_meta',
  'label'       => 'Background Color',
  'description' => 'The background color shown if the image is too small for the page. Leave blank for transparent.',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'background_size',
  'scope'       => 'post_meta',
  'label'       => 'Background Size',
  'description' => 'Supports any valid CSS value for <code>background-size</code>. This can be used to "zoom" a background image to a specific size. Leave blank for a default 1X zoom level.',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'background_position',
  'scope'       => 'post_meta',
  'label'       => 'Background Position',
  'description' => 'Supports any valid CSS value for <code>background-position</code>. Leave blank to center the image.'
));

piklist('field', array(
  'type'        => 'radio',
  'field'       => 'background_repeat',
  'scope'       => 'post_meta',
  'label'       => 'Background Repeat',
  'description' => 'Is the background image a repeating pattern?',
  'choices'     => array(
    'repeat'    => 'Repeat',
    'no-repeat' => 'No Repeat'
  ),
));

?>
