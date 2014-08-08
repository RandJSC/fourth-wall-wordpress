<?php
/**
 * Fourth Wall Events
 * WordPress Functions File
 */

$base_path = trailingslashit(dirname(__FILE__)) . 'includes/functions/';

require_once $base_path . 'http-timeout-fix.php';
require_once $base_path . 'image-sizes.php';
require_once $base_path . 'login.php';
require_once $base_path . 'menus.php';
require_once $base_path . 'plugins.php';
require_once $base_path . 'post-types.php';
require_once $base_path . 'shortcodes.php';
require_once $base_path . 'styles.php';
require_once $base_path . 'utilities.php';
require_once $base_path . 'widgets.php';

?>
