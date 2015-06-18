<?php
/*
Title: Slider Settings
Setting: fwe_settings
Tab: Sliders
*/

piklist('field', array(
  'type'        => 'number',
  'field'       => 'homepage_slider_speed',
  'label'       => 'Homepage Slider Speed',
  'description' => 'In seconds',
  'value'       => 5,
  'attributes'  => array(
    'min'  => 1,
    'max'  => 30,
    'step' => 1,
  ),
));

piklist('field', array(
  'type'        => 'number',
  'field'       => 'testimonial_slider_speed',
  'label'       => 'Testimonial Slider Speed',
  'description' => 'In seconds',
  'value'       => 8,
  'attributes'  => array(
    'min'  => 1,
    'max'  => 30,
    'step' => 1,
  ),
));

piklist('field', array(
  'type'        => 'number',
  'field'       => 'global_slider_speed',
  'label'       => 'Generic Slider Speed',
  'description' => 'In seconds',
  'help'        => 'This setting controls the speed of all sliders on the site except Testimonials and Homepage',
  'value'       => 5,
  'attributes'  => array(
    'min'  => 1,
    'max'  => 30,
    'step' => 1,
  ),
));
