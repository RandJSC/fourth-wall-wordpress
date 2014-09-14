<?php
/*
Title: Call to Action Fields
Post Type: call_to_action
Context: normal
Priority: high
*/

piklist('field', array(
  'type'       => 'text',
  'field'      => 'button_text',
  'label'      => 'Button Text',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'link_url',
  'label'      => 'Link URL',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'        => 'file',
  'field'       => 'background_image',
  'label'       => 'Background Image',
  'description' => 'SVG recommended',
  'scope'       => 'post_meta',
));

piklist('field', array(
  'type'  => 'colorpicker',
  'field' => 'background_color',
  'label' => 'Background Color',
  'scope' => 'post_meta',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'background_size',
  'label'       => 'Background Size',
  'scope'       => 'post_meta',
  'description' => 'Accepts any valid CSS <code>background-size</code> value.',
));

piklist('field', array(
  'type'        => 'text',
  'field'       => 'background_position',
  'label'       => 'Background Position',
  'scope'       => 'post_meta',
  'description' => 'Accepts any valid CSS <code>background-position</code> value.',
));

piklist('field', array(
  'type'        => 'radio',
  'field'       => 'background_repeat',
  'label'       => 'Background Repeat',
  'scope'       => 'post_meta',
  'description' => 'Select "repeat" if the background is a repeating pattern.',
  'choices'     => array(
    'repeat'    => 'Repeat',
    'no-repeat' => 'No Repeat'
  ),
));
?>
