<?php
/**
 * Fourth Wall Events
 * Stylesheet Queue
 */

function fwe_enqueue_styles() {
  // Disable dashicons if we don't need them
  if (!is_user_logged_in() && !is_admin()) {
    wp_deregister_style('dashicons');
  }

  $theme_uri = get_stylesheet_directory_uri();
  $styles    = array(
    'source-sans-pro' => array(
      'src'     => '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,400italic,600italic',
      'deps'    => false,
      'version' => '0.1.0',
      'media'   => 'all',
    ),
    'fwe-main' => array(
      'src'     => "$theme_uri/css/style.css",
      'deps'    => array(
        'source-sans-pro',
      ),
      'version' => '0.1.0',
      'media'   => 'screen',
    ),
  );

  foreach ($styles as $slug => $info) {
    wp_register_style($slug, $info['src'], $info['deps'], $info['version'], $info['media']);
  }

  wp_enqueue_style('fwe-main');
}
add_action('wp_enqueue_scripts', 'fwe_enqueue_styles');

?>
