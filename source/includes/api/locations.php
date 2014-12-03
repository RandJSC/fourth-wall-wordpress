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

  public function get_posts($filter = array(), $context = 'view', $type = 'location', $page = 1) {
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
      $gallery_count    = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS p LEFT JOIN $wpdb->postmeta AS m ON p.ID = m.post_id WHERE p.post_type = 'gallery' AND m.meta_key = 'location_id' AND m.meta_value = '$loc->ID'");
      $case_study_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts AS p LEFT JOIN $wpdb->postmeta AS m ON p.ID = m.post_id WHERE p.post_type = 'case_study' AND m.meta_key = 'location_id' AND m.meta_value = '$loc->ID'");
      $permalink        = get_permalink($loc->ID);
      $item             = get_object_vars($loc);

      unset($item['post_title']);
      unset($item['post_content']);

      $item['title']        = apply_filters('the_title', $loc->post_title);
      $item['content']      = apply_filters('the_content', $loc->post_content);
      $item['galleries']    = (int) $gallery_count;
      $item['case_studies'] = (int) $case_study_count;
      $item['latitude']     = (float) get_post_meta($loc->ID, 'latitude', true);
      $item['longitude']    = (float) get_post_meta($loc->ID, 'longitude', true);
      $item['links']        = array(
        'permalink' => $permalink,
        'json'      => site_url('/wp-json/fwe/locations/' . $loc->ID),
      );

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
    } else {
      $post['event_date']   = get_post_meta($post['ID'], 'event_date', true);
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
