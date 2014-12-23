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
    // TODO
  }
}
?>
