<?php
/**
 * Fourth Wall Events
 * WordPress Functions File
 */

$base_path = trailingslashit(dirname(__FILE__)) . 'includes/';
$functions = $base_path . 'functions/';
$walkers   = $base_path . 'walkers/';

require_once $walkers . 'class.walker-fwe-quicklinks.php';

require_once $functions . 'hooks.php';
require_once $functions . 'http-timeout-fix.php';
require_once $functions . 'image-sizes.php';
require_once $functions . 'login.php';
require_once $functions . 'menus.php';
require_once $functions . 'plugins.php';
require_once $functions . 'post-types.php';
require_once $functions . 'settings.php';
require_once $functions . 'shortcodes.php';
require_once $functions . 'styles.php';
require_once $functions . 'theme-support.php';
require_once $functions . 'utilities.php';
require_once $functions . 'widgets.php';

?>
