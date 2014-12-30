<?php
/*
Title: MailChimp Settings
Setting: fwe_settings
Tab: MailChimp
*/

// Load MailChimp API wrapper
$theme_dir = trailingslashit(dirname(__FILE__)) . '../../../';
require_once $theme_dir . 'includes/vendor/autoload.php';

$fwe_settings = get_option('fwe_settings');

piklist('field', array(
  'type'        => 'text',
  'field'       => 'mailchimp_api_key',
  'label'       => 'MailChimp API Key',
  'description' => 'You can find this by viewing your profile in MailChimp and selecting Extras &gt; API Keys',
  'value'       => 'cbb2a7e4d7c04540270ae1d494efe0c0-us8',
));

if (fwe_theme_option_exists('mailchimp_api_key')) {
  $mc    = new \Drewm\MailChimp($fwe_settings['mailchimp_api_key']);
  $lists = $mc->call('lists/list');

  $list_choices = array('' => '-- Select a List --');

  foreach ($lists['data'] as $list) {
    $list_choices[$list['id']] = $list['name'];
  }

  piklist('field', array(
    'type'    => 'select',
    'field'   => 'mailchimp_list_id',
    'label'   => 'Subscriber List',
    'choices' => $list_choices,
  ));
}

piklist('field', array(
  'type'        => 'textarea',
  'field'       => 'subscribe_success_message',
  'label'       => 'Subscription Success Message',
  'description' => 'Displayed to users upon successful subscription to FWE\'s email list. No HTML allowed.',
  'value'       => 'Thanks for subscribing! Please check your inbox for a confirmation link.',
  'attributes'  => array(
    'rows' => 4,
    'cols' => 40,
  ),
));
?>
