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
//add_action('wp_enqueue_scripts', 'fwe_enqueue_styles');

function fwe_styles($assets) {

  $theme_uri  = get_stylesheet_directory_uri();
  $theme_dir  = trailingslashit(get_stylesheet_directory());
  $theme_json = json_decode(file_get_contents($theme_dir . 'theme.json'), true);

  $assets['styles'][] = array(
    'handle'  => 'fwe-main',
    'src'     => "$theme_uri/style.css",
    'deps'    => false,
    'version' => $theme_json['version'],
    'media'   => 'screen',
  );

  return $assets;
}
add_filter('piklist_assets', 'fwe_styles');

?>
