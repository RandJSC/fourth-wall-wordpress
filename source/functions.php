<?php
/**
 * Fourth Wall Events
 * WordPress Functions File
 */

$base_path = trailingslashit(dirname(__FILE__)) . 'includes/functions/';

include_once $base_path . 'http-timeout-fix.php';
include_once $base_path . 'image-sizes.php';
include_once $base_path . 'login.php';
include_once $base_path . 'menus.php';
include_once $base_path . 'plugins.php';
include_once $base_path . 'shortcodes.php';
include_once $base_path . 'styles.php';
include_once $base_path . 'utilities.php';
include_once $base_path . 'widgets.php';

?>
