<div class="main-page-slider">
  <div class="slides">
    <?php for ($i = 0; $i < count($slider_images['image']); $i++): ?>
      <?php
      $title    = $slider_images['title'][$i];
      $link_url = $slider_images['link_url'][$i];
      $image    = $slider_images['image'][$i][0];
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
