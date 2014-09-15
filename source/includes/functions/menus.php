<?php
/**
 * Fourth Wall Events
 * Navigation Menus
 */

function fwe_register_nav_menus() {
  if (!function_exists('register_nav_menus')) return;

  register_nav_menus(array(
    'main_nav'     => 'Main Navigation',
    'quick_links'  => 'QuickLinks',
    'social_links' => 'Social Links',
  ));
}
add_action('init', 'fwe_register_nav_menus');

?>
