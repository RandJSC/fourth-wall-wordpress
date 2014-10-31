<?php
/*
Title: Accordion
Post Type: accordion
Context: normal
Priority: high
*/

piklist('field', array(
  'type'     => 'group',
  'field'    => 'accordion_panes',
  'label'    => 'Accordion Panes',
  'add_more' => true,
  'fields'   => array(
    array(
      'type'  => 'text',
      'field' => 'title',
      'label' => 'Title',
    ),
    array(
      'type'        => 'file',
      'field'       => 'icon',
      'label'       => 'Icon',
      'description' => 'This should be a square PNG or SVG w/ a white foreground.',
      'validate'    => array(
        array(
          'limit' => array(
            'max' => 1,
          ),
        ),
      ),
    ),
    array(
      'type'  => 'colorpicker',
      'field' => 'header_background',
      'label' => 'Header Background',
    ),
    array(
      'type'        => 'editor',
      'field'       => 'content',
      'label'       => 'Content',
      'description' => 'Things will explode if you try to embed another accordion here.',
    ),
  ),
));
?>
