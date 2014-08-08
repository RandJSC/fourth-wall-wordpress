<?php
/**
 * Fourth Wall Events
 * Navigation Menus
 */

function fwe_register_nav_menus() {
  if (!function_exists('register_nav_menus')) return;

  register_nav_menus(array(
    'main_nav' => 'Main Navigation',
  ));
}
add_action('init', 'fwe_register_nav_menus');

?>
