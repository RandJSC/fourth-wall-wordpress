<?php
/**
 * Fourth Wall Events
 * Single Case Study Template
 */

get_header();

global $post, $fwe_settings;

$has_banner = array_key_exists('where_weve_been_banner', $fwe_settings) && !empty($fwe_settings['where_weve_been_banner']);

if ($has_banner) {
  $banner = wp_get_attachment_image_src($fwe_settings['where_weve_been_banner'], 'full');
  $banner_link = get_post_type_archive_link('case-study');
}
?>

<?php if ($has_banner): ?>
  <section class="banner">
    <figure id="page-banner">

    </figure>
  </section>
<?php endif; ?>
