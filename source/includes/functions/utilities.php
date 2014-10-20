<?php
/**
 * Fourth Wall Events
 * Utility Functions
 */

function fwe_get_cta() {
  global $post;

  if ($post && property_exists($post, 'ID')) {
    $post_id = $post->ID;
    $cta_id  = get_post_meta($post_id, 'call_to_action', true);
    $cta     = get_post($cta_id);
  } else {
    $cta = get_posts(array(
      'posts_per_page' => 1,
      'orderby'        => 'rand',
      'post_type'      => 'call_to_action',
      'post_status'    => 'publish',
    ));

    if (count($cta) > 0) {
      $cta = $cta[0];
    }
  }

  if (isset($cta)) {
    return $cta;
  }

  return null;
}

function fwe_style_attribute($params = array()) {
  $value = '';

  foreach ($params as $key => $val) {
    if (empty($val)) {
      continue;
    }
    $value .= "{$key}:{$val};";
  }

  if (!empty($value)) {
    $value = ' style="' . $value . '"';
    return $value;
  }

  return '';
}

function fwe_is_url_local($url) {
  if (!preg_match('/^https?\:\/\//', $url)) {
    return true;
  }

  $site_url  = site_url();
  $is_remote = strpos($url, $site_url) === false;

  return !$is_remote;
}

function fwe_google_maps_link($params = array()) {

  $url_base = 'https://maps.google.com/?q=';

  if (array_key_exists('address', $params)) {
    $pieces = array(
      $params['address'],
      $params['city'],
      $params['state'],
      $params['zip_code'],
    );
  } else {
    $pieces = $params;
  }

  if (is_array($pieces)) {
    $oneliner = implode(', ', $pieces);
  } else {
    $oneliner = $pieces;
  }

  $query = urlencode($oneliner);

  return $url_base . $query;
}

function fwe_gforms_request_signature($route, $method = 'GET') {
  $api_key     = 'bf72b8cd58';
  $private_key = '3d86b92f6e1a864';
  $expiration  = strtotime('+60 mins');
  $sign_string = sprintf('%s:%s:%s:%s', $api_key, $method, $route, $expires);
  $hash        = hash_hmac('sha1', $sign_string, $private_key, true);

  return rawurlencode(base64_encode($hash));
}

function fwe_is_post($post) {
  return is_a($post, 'WP_Post');
}

function fwe_list_hooked_functions($tag = false) {
  global $wp_filter;

  $hook = array();

  if ($tag) {
    $hook[$tag] = $wp_filter[$tag];

    if (!is_array($hook[$tag])) {
      trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
      return;
    }
  } else {
    $hook = $wp_filter;
    ksort($hook);
  }

  foreach ($hook as $tag => $priority) {
    var_dump($tag, $priority);
  }
}

function fwe_tag_list($tags = array()) {
  if (empty($tags) || !is_array($tags)) return false;

  $links = array_map(function($tag) {
    $link = get_term_link($tag->term_id, $tag->taxonomy);
    return '<a href="' . $link . '">' . $tag->name . '</a>';
  }, $tags);

  echo implode(', ', $links);
}

?>
