<?php
/**
 * Fourth Wall Events
 * WordPress Functions File
 */

$base_path = trailingslashit(dirname(__FILE__)) . 'includes/';
$functions = $base_path . 'functions/';
$walkers   = $base_path . 'walkers/';

// Make sure Piklist is installed and activated
function fwe_admin_init() {
  if (is_admin()) {
    include_once dirname(__FILE__) . '/includes/class-piklist-checker.php';

    if (!piklist_checker::check(__FILE__, 'theme')) {
      return;
    }
  }
}
add_action('init', 'fwe_admin_init');

if (file_exists($base_path . 'vendor/autoload.php')) {
  require_once $base_path . 'vendor/autoload.php';
}

require_once $base_path . 'PiklistHelper.php';
PiklistHelper::Initiate();

require_once $walkers . 'class.walker-fwe-quicklinks.php';
require_once $walkers . 'class.walker-fwe-socials.php';

require_once $functions . 'api.php';
require_once $functions . 'hooks.php';
require_once $functions . 'http-timeout-fix.php';
require_once $functions . 'file-types.php';
require_once $functions . 'image-sizes.php';
require_once $functions . 'login.php';
require_once $functions . 'menus.php';
require_once $functions . 'plugins.php';
require_once $functions . 'post-types.php';
require_once $functions . 'taxonomies.php';
require_once $functions . 'settings.php';
require_once $functions . 'shortcodes.php';
require_once $functions . 'styles.php';
require_once $functions . 'theme-support.php';
require_once $functions . 'utilities.php';
require_once $functions . 'widgets.php';
require_once $functions . 'excerpts.php';

?>
