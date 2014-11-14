<?php
/**
 * Fourth Wall Events
 * Team Members Custom Post Type API
 */

class FourthWall_TeamMembers extends WP_JSON_CustomPostType {

  protected $base = '/fwe/team-members';
  protected $type = 'team_member';

  public function register_routes($routes) {
    $routes = parent::register_routes($routes);

    return $routes;
  }

}

?>
