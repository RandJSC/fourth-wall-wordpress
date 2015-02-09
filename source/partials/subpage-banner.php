<?php
global $post;

$classes = array( 'banner' );

if (fwe_is_post($post)) {
  $parent  = fwe_get_root_parent($post);
  $classes[] = $parent->post_name;
}

$classes = 'class="' . implode(' ', $classes) . '"';
?>
<?php if ($banner && $banner['banner']): ?>
  <?php
  $banner_src = wp_get_attachment_image_src($banner['banner'], 'full');
  ?>
  <section <?php echo $classes; ?>>
    <figure id="page-banner">
      <img src="<?php echo $banner_src[0]; ?>" alt="<?php echo $banner['caption']; ?>" width="100%">
      <figcaption><?php echo $banner['caption']; ?></figcaption>
    </figure>
  </section>
<?php endif; ?>
