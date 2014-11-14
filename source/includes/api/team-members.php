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

  protected function prepare_post($post, $context = 'view') {
    $post = parent::prepare_post($post, $context);

    // Add custom fields
    $post['surname']       = get_post_meta($post['ID'], 'surname', true);
    $post['job_title']     = get_post_meta($post['ID'], 'job_title', true);
    $post['location']      = get_post_meta($post['ID'], 'location', true);
    $post['email_address'] = get_post_meta($post['ID'], 'email_address', true);
    $post['facebook']      = get_post_meta($post['ID'], 'facebook', true);
    $post['twitter']       = get_post_meta($post['ID'], 'twitter', true);
    $post['instagram']     = get_post_meta($post['ID'], 'instagram', true);
    $post['linkedin']      = get_post_meta($post['ID'], 'linkedin', true);
    $post['pinterest']     = get_post_meta($post['ID'], 'pinterest', true);
    $post['google_plus']   = get_post_meta($post['ID'], 'google_plus', true);

    return $post;
  }

}

?>
