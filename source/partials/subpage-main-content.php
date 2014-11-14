<?php
$images = get_post_meta(get_the_ID(), 'slider_images', true);
?>
<section id="main-page-content" class="content-section">
  <article <?php post_class(); ?>>

    <div class="post-header padded">
      <h1><?php the_title(); ?></h1>
      <hr>
    </div>

    <?php if (has_post_thumbnail()): ?>
      <?php
      $thumb_id = get_post_thumbnail_id();
      $thumb_src = wp_get_attachment_image_src($thumb_id, 'full');
      ?>
      <div class="post-featured-image">
        <img src="<?php echo $thumb_src[0]; ?>" width="100%" alt="<?php the_title(); ?>">
      </div>
    <?php endif; ?>

    <div class="post-content padded">
      <?php the_content(); ?>
    </div>
  </article>
</section>
