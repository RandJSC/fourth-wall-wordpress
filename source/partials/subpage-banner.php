<?php if ($banner && $banner['banner']): ?>
  <?php
  $banner_src = wp_get_attachment_image_src($banner['banner']);
  ?>
  <section class="banner">
    <figure id="page-banner">
      <img src="<?php echo $banner_src[0]; ?>" alt="<?php echo $banner['caption']; ?>" width="100%">
      <figcaption><?php echo $banner['caption']; ?></figcaption>
    </figure>
  </section>
<?php endif; ?>
