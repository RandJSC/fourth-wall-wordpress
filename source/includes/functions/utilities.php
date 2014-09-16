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
?>
