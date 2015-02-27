<?php
/**
 * Fourth Wall Events
 * Required & Recommended Plugins
 */

require_once trailingslashit(dirname(__FILE__)) . '../class-tgm-plugin-activation.php';

function fwe_register_plugins() {

  $plugins = array(
    // The spinal column of this site
    array(
      'name'     => 'PIKLIST | Rapid development framework',
      'slug'     => 'piklist',
      'required' => true,
    ),
    array(
      'name'     => 'JSON REST API (WP API)',
      'slug'     => 'json-rest-api',
      'required' => true,
    ),

    // SEO/Front-end
    array(
      'name'     => 'WordPress SEO by Yoast',
      'slug'     => 'wordpress-seo',
      'required' => true,
    ),

    array(
      'name'     => 'Disqus Comment System',
      'slug'     => 'disqus-comment-system',
      'required' => true,
    ),

    // Debug + Optimization
    array(
      'name'     => 'Debug Bar',
      'slug'     => 'debug-bar',
      'required' => false,
    ),
    array(
      'name'     => 'Debug Bar Action Hooks',
      'slug'     => 'debug-bar-action-hooks',
      'required' => false,
    ),
    array(
      'name'     => 'WP Optimize',
      'slug'     => 'wp-optimize',
      'required' => false,
    ),
    array(
      'name'     => 'Regenerate Thumbnails',
      'slug'     => 'regenerate-thumbnails',
      'required' => false,
    ),
    array(
      'name'     => 'Asset Queue Manager',
      'slug'     => 'asset-queue-manager',
      'required' => false,
    ),
  );

  $config = array(
    'is_automatic' => true,
  );

  tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'fwe_register_plugins');

?>
