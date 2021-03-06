<?php
global $fwe_settings;
$slider_speed = fwe_theme_option_exists('global_slider_speed') ? $fwe_settings['global_slider_speed'] : 8;
?>
<div class="main-page-slider">
  <div class="slides" data-speed="<?php echo esc_attr($slider_speed); ?>">
    <?php for ($i = 0; $i < count($slider_images['image']); $i++): ?>
      <?php
      $title    = $slider_images['title'][$i];
      $link_url = $slider_images['link_url'][$i];
      $image    = fwe_get_first_valid_image($slider_images['image'][$i]);
      $image    = wp_get_attachment_image_src($image, 'full');
      $src_attr = fwe_lazy_load_img_src($image[0], $i);
      ?>
      <figure class="slide">
        <a href="<?php echo esc_url($link_url); ?>">
          <img <?php echo $src_attr; ?> alt="<?php echo $title; ?>" width="100%">
        </a>
      </figure>
    <?php endfor; ?>
  </div>
</div>
