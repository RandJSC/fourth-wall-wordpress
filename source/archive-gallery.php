<?php
/**
 * Fourth Wall Events
 * Gallery Archive Template
 */

get_header();

include(locate_template('partials/gallery-banner.php'));
include(locate_template('partials/gallery-quick-links.php'));
include(locate_template('partials/gallery-archive-search.php'));
include(locate_template('partials/gallery-results.php'));

get_footer();
?>
