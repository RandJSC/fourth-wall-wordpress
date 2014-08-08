<?php
/**
 * Fourth Wall Events
 * Stylesheet Queue
 */

function fwe_enqueue_styles() {
  $theme_uri = get_stylesheet_directory_uri();
  $styles    = array(
    'fwe-main' => array(
      'src'     => "$theme_uri/style.css",
      'deps'    => false,
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
