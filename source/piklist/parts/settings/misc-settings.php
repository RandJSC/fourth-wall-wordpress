<?php
/*
Title: Misc. Settings
Setting: fwe_settings
Tab: Misc.
*/

global $wpdb;

$gforms_query = $wpdb->get_results("SELECT id,title FROM {$wpdb->prefix}rg_form");
$form_choices = array('' => '-- Select a Form --');

foreach ($gforms_query as $form) {
  $form_choices[$form->id] = $form->title;
}

piklist('field', array(
  'type'  => 'text',
  'field' => 'gforms_api_key',
  'label' => 'Gravity Forms API Key',
  'help'  => 'Get this from the Gravity Forms settings page, under API.',
  'value' => 'bf72b8cd58',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'gforms_private_key',
  'label' => 'Gravity Forms Private Key',
  'help'  => 'Get this from the Gravity Forms settings page, under API.',
  'value' => '3d86b92f6e1a864',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'google_maps_api_key',
  'label' => 'Google Maps API Key',
  'value' => 'AIzaSyBi9BiBeHzphNOXhiyaZTWdUtncrD3afdg',
));

piklist('field', array(
  'type'        => 'select',
  'field'       => 'contact_form_id',
  'label'       => 'Contact Form',
  'description' => "Which Gravity Form should the footer contact form send its responses to?",
  'choices'     => $form_choices,
));

piklist('field', array(
  'type'        => 'editor',
  'field'       => 'where_weve_been_intro',
  'label'       => 'Where We\'ve Been Intro Text',
  'description' => 'This text appears at the top of all Gallery and Case Study archive pages',
));

?>
