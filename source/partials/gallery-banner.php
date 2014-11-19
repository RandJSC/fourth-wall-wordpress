<?php
global $fwe_settings;

$has_banner = array_key_exists('where_weve_been_banner', $fwe_settings) && !empty($fwe_settings['where_weve_been_banner']);

$banner_link = isset($banner_link) ? $banner_link : get_post_type_archive_link('gallery');

if ($has_banner):
  $banner = wp_get_attachment_image_src($fwe_settings['where_weve_been_banner'], 'full');
?>
  <section class="banner">
    <figure id="page-banner">
      <a href="<?php echo $banner_link; ?>">
        <img src="<?php echo $banner[0]; ?>" alt="Where We've Been" width="100%">
        <figcaption>Where We've Been</figcaption>
      </a>
    </figure>
  </section>
<?php endif; ?>
