<?php
/*
Title: Page Background
Post Type: page
Context: normal
Priority: high
*/

piklist('field', array(
  'type'     => 'group',
  'field'    => 'page_backgrounds',
  'label'    => 'Responsive Backgrounds',
  'add_more' => true,
  'columns'  => 12,
  'fields'   => array(
    array(
      'type'        => 'number',
      'field'       => 'min_width',
      'label'       => 'Minimum Window Width (in pixels)',
      'description' => 'Window width in pixels. Images with higher minimum widths override lower ones.',
      'columns'     => 8,
      'attributes'  => array(
        'min'  => 0,
        'max'  => 1920,
        'step' => 1,
      ),
    ),

    array(
      'type'        => 'color',
      'field'       => 'background_color',
      'label'       => 'Background Color',
      'description' => 'The background color shown if the image is too small for the page. Leave blank for transparent.',
      'columns'     => 2,
      'attributes'  => array(
        'pattern' => '#[a-fA-F0-9]{6}',
      ),
    ),

    array(
      'type'       => 'range',
      'field'      => 'color_opacity',
      'label'      => 'Background Color Opacity',
      'columns'    => 6,
      'value'      => 100,
      'attributes' => array(
        'min'  => 0,
        'max'  => 100,
        'step' => 1,
      ),
    ),

    array(
      'type'        => 'file',
      'field'       => 'background_image',
      'label'       => 'Background Image',
      'description' => 'This image will be used as the page\'s background, stretched to fill the width of the user\'s screen. For best results, use an SVG.',
      'columns'     => 12,
    ),

    array(
      'type'        => 'text',
      'field'       => 'background_size',
      'label'       => 'Background Size',
      'description' => 'Supports any valid CSS value for <code>background-size</code>. This can be used to "zoom" a background image to a specific size. Leave blank for a default 1X zoom level.',
      'columns'     => 12,
    ),

    array(
      'type'        => 'text',
      'field'       => 'background_position',
      'label'       => 'Background Position',
      'description' => 'Supports any valid CSS value for <code>background-position</code>. Leave blank to center the image.',
      'columns'     => 12,
    ),

    array(
      'type'        => 'radio',
      'field'       => 'background_repeat',
      'label'       => 'Background Repeat',
      'description' => 'Is the background image a repeating pattern?',
      'columns'     => 12,
      'choices'     => array(
        'repeat'    => 'Repeat',
        'no-repeat' => 'No Repeat',
      ),
    ),
  ),
));

?>
