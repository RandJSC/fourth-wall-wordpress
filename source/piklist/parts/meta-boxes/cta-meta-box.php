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
?>
