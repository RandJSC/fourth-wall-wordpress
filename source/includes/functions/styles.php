<?php
/**
 * Fourth Wall Events
 * Stylesheet Queue
 */

function fwe_enqueue_styles() {
  $theme_uri = get_stylesheet_directory_uri();
  $styles    = array(
    'normalize' => array(
      'src'     => "$theme_uri/css/normalize.css",
      'deps'    => false,
      'version' => '3.0.1',
      'media'   => 'all',
    ),
    'font-awesome' => array(
      'src'     => "$theme_uri/css/font-awesome.min.css",
      'deps'    => false,
      'version' => '4.1.0',
      'media'   => 'all',
    ),
    'source-sans-pro' => array(
      'src'     => '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,400italic,600italic',
      'deps'    => false,
      'version' => '0.1.0',
      'media'   => 'all',
    ),
    'slick-carousel' => array(
      'src'     => "$theme_uri/css/slick.css",
      'deps'    => false,
      'version' => '1.3.7',
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
