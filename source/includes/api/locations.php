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
    return $routes;
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
