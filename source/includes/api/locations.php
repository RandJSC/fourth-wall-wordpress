<?php
/**
 * Fourth Wall Events
 * Location Custom Post Type API
 */

class FourthWall_Locations extends WP_JSON_CustomPostType {

  protected $base = '/fwe/locations';
  protected $type = 'location';

  public function register_routes($routes) {
    $routes = parent::register_routes($routes);

    $routes['/fwe/location-pins'] = array(
      array(
        'callback'  => array( $this, 'get_pins' ),
        'methods'   => WP_JSON_Server::READABLE,
        'v1_compat' => true,
      ),
    );

    return $routes;
  }

  public function get_pins($context = 'view') {
    $params = array(
      'post_type'      => 'location',
      'post_status'    => 'publish',
      'orderby'        => 'name',
      'posts_per_page' => -1,
    );

    // [todo] - get pins via WP_Query and render as WP_JSON_Response instance
  }

  protected function prepare_post($post, $context = 'view') {
    $post = parent::prepare_post($post, $context);

    if ($post['type'] === 'location') {
      $post['latitude']     = get_post_meta($post['ID'], 'latitude', true);
      $post['longitude']    = get_post_meta($post['ID'], 'longitude', true);
      $post['case_studies'] = $this->get_linked_content($post['ID'], 'case_study');
      $post['galleries']    = $this->get_linked_content($post['ID'], 'gallery');
    }

    return $post;
  }

  private function get_linked_content($post_id, $post_type) {
    $results = array();
    $params  = array(
      'post_type'      => $post_type,
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'date',
      'order'          => 'DESC',
      'meta_key'       => 'location_id',
      'meta_value'     => $post_id,
    );
    $query   = new WP_Query();
    $posts   = $query->query($params);

    if (!$posts) {
      return $results;
    }

    foreach ($posts as $post) {
      $post      = get_object_vars($post);
      $results[] = $this->prepare_post($post);
    }

    return $results;
  }

}

?>
