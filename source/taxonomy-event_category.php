<?php
/**
 * Fourth Wall Events
 * Gallery Archive Template
 */

global $wp_query;
$term = $wp_query->queried_object;

get_header();

include(locate_template('partials/gallery-banner.php'));
include(locate_template('partials/gallery-quick-links.php'));
include(locate_template('partials/gallery-archive-search.php'));
?>

<section id="main-page-content" class="content-section padded">
  <div class="page-header">
    <h1><?php echo $term->name; ?></h1>
    <hr>
  </div>

  <?php include(locate_template('partials/gallery-archive-intro.php')); ?>
  <?php include(locate_template('partials/gallery-results.php')); ?>
</section>

<?php
fwe_pagination_links();
get_footer();
?>
