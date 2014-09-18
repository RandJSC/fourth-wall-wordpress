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
  'type'        => 'select',
  'field'       => 'contact_form_id',
  'label'       => 'Contact Form',
  'description' => "Which Gravity Form should the footer contact form send its responses to?",
  'choices'     => $form_choices,
));

?>
