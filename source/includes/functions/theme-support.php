<?php
/**
 * Fourth Wall Events
 * Misc Theme Support Declarations
 */

function fwe_add_html5_search() {
  add_theme_support('html5', array( 'search-form' ));
}
add_action('init', 'fwe_add_html5_search');

?>
