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
    global $wpdb;

    $params   = array(
      'post_type'      => 'location',
      'post_status'    => 'publish',
      'orderby'        => 'name',
      'posts_per_page' => -1,
    );
    $query    = new WP_Query();
    $results  = $query->query($params);
    $data     = array();
    $response = new WP_JSON_Response();

    if (!$results) {
      $response->set_data(array());
      return $response;
    }

    foreach ($results as $loc) {
      $gallery_count    = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS p LEFT JOIN $wpdb->postmeta AS m ON p.ID = m.post_id WHERE p.post_type = 'gallery' AND m.meta_key = 'location_id' AND m.meta_value = '$loc->ID'");
      $case_study_count = (int) $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS p LEFT JOIN $wpdb->postmeta AS m ON p.ID = m.post_id WHERE p.post_type = 'case_study' AND m.meta_key = 'location_id' AND m.meta_value = '$loc->ID'");
      $permalink        = get_permalink($loc->ID);
      $item             = get_object_vars($loc);

      $item['galleries']    = $gallery_count;
      $item['case_studies'] = $case_study_count;
      $item['permalink']    = $permalink;

      $data[] = $item;
    }

    $response->set_data($data);
    return $response;
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
