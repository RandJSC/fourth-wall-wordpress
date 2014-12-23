<?php
/**
 * Fourth Wall Events
 * WP JSON API Hooks
 */

$api_dir = trailingslashit(dirname(__FILE__)) . '../api/';

require_once $api_dir . 'team-members.php';
require_once $api_dir . 'locations.php';
require_once $api_dir . 'hire-us.php';
require_once $api_dir . 'subscriptions.php';

function fwe_api_init($server) {
  $team_members  = new FourthWall_TeamMembers($server);
  $locations     = new FourthWall_Locations($server);
  $hire_us       = new FourthWall_HireUs($server);
  $subscriptions = new FourthWall_EmailSubscriptions($server);

  add_filter('json_endpoints', array($team_members, 'register_routes'));
  add_filter('json_endpoints', array($locations, 'register_routes'));
  add_filter('json_endpoints', array($hire_us, 'register_routes'));
  add_filter('json_endpoints', array($subscriptions, 'register_routes'));
}
add_action('wp_json_server_before_serve', 'fwe_api_init');

?>
