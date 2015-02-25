<?php
global $fwe_settings;

$has_banner = fwe_theme_option_exists('where_weve_been_banner');

if ($has_banner):
  $banner = wp_get_attachment_image_src($fwe_settings['where_weve_been_banner'], 'full');
?>
  <section class="banner where-weve-been">
    <figure id="page-banner">
      <img src="<?php echo $banner[0]; ?>" alt="Where We've Been" width="100%">
      <figcaption>Where We've Been</figcaption>
    </figure>
  </section>
<?php endif; ?>
