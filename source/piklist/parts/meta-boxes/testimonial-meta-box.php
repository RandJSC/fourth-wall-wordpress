<?php
/*
Title: Testimonial
Post Type: testimonial
Context: normal
Priority: high
*/

piklist('field', array(
  'type'  => 'text',
  'field' => 'author_name',
  'label' => 'Author Name',
  'help'  => 'The person to whom this testimonial should be attributed',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'author_position',
  'label' => 'Author Position (job title)',
));

?>
