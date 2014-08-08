<?php
/**
 * Fourth Wall Events
 * WordPress Login Logo Customization
 */

function fwe_login_logo() {
  $settings = get_option('fwe_theme_options');
  $logo = $settings['login_logo'];

  // [todo] - figure out how Piklist stores attachment info in theme settings
  // [todo] - display image in place of WP logo
}
add_action('login_enqueue_scripts', 'fwe_login_logo');

?>
