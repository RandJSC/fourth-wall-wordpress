<?php
/**
 * Fourth Wall Events
 * Theme Options Page Definitions
 */

function fwe_register_settings_pages($pages) {

  $pages[] = array(
    'page_title'  => 'Fourth Wall Theme Options',
    'menu_title'  => 'Theme Options',
    'capability'  => 'manage_options',
    'menu_slug'   => 'fwe_settings',
    'setting'     => 'fwe_settings',
    'menu_icon'   => 'dashicons-admin-generic',
    'page_icon'   => 'dashicons-admin-generic',
    'single_line' => true,
    'default_tab' => 'Images',
    'save_text'   => 'Save Theme Options',
  );

  return $pages;
}
add_filter('piklist_admin_pages', 'fwe_register_settings_pages');

?>
