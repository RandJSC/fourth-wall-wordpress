<?php
/**
 * Fourth Wall Events
 * Email Subscription API
 */

class FourthWall_EmailSubscriptions {

  public function register_routes($routes) {
    $routes['/fwe/subscriptions'] = array(
      array( array( $this, 'create_subscription' ), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
    );

    return $routes;
  }

  public function create_subscription($data = null) {
    $settings = get_option('fwe_settings');

    if (!fwe_theme_option_exists('mailchimp_api_key')) {
      return new WP_Error('apikey', 'Please enter a MailChimp API key in Theme Options');
    }

    if (!fwe_theme_option_exists('mailchimp_list_id')) {
      return new WP_Error('nolist', 'Please select a MailChimp list in Theme Options');
    }

    if (!array_key_exists('name', $data) || empty($data['name'])) {
      return new WP_Error('noname', 'Please enter your name and try again!');
    }

    if (!array_key_exists('email', $data) || empty($data['email']) || !is_email($data['email'])) {
      return new WP_Error('noemail', 'Please enter a valid email address and try again!');
    }

    $first_name = fwe_get_given_name($data['name']);
    $last_name  = fwe_get_surname($data['name']);
    $chimp      = new \Drewm\MailChimp($settings['mailchimp_api_key']);
    $result     = $chimp->call('lists/subscribe', array(
      'id'         => $settings['mailchimp_list_id'],
      'email'      => array( 'email' => $data['email'] ),
      'merge_vars' => array( 'FNAME' => $first_name, 'LNAME' => $last_name ),
    ));

    if (array_key_exists('status', $result) && $result['status'] === 'error') {
      return new WP_Error('error', $result['error']);
    }

    $resp              = new WP_JSON_Response();
    $result['status']  = 'success';
    $result['message'] = $settings['subscribe_success_message'];

    $resp->set_data($result);

    return $resp;
  }
}
?>
