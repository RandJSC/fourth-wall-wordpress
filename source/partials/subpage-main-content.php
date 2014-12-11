<?php
$page_id     = get_the_ID();
$images      = get_post_meta($page_id, 'slider_images', true);
$pad_content = get_post_meta($page_id, 'pad_content', true);
$pad_content = $pad_content === 'yes' ? ' padded' : '';
?>
<section id="main-page-content" class="content-section">
  <article itemscope itemtype="http://schema.org/WebPage" <?php post_class(); ?>>

    <div class="post-header padded">
      <?php include(locate_template('partials/sharing-link.php')); ?>
      <h1 itemprop="headline"><?php the_title(); ?></h1>
      <hr>
    </div>

    <?php if (has_post_thumbnail()): ?>
      <?php
      $thumb_id  = get_post_thumbnail_id();
      $thumb_src = wp_get_attachment_image_src($thumb_id, 'full');
      ?>
      <div class="post-featured-image">
        <img src="<?php echo $thumb_src[0]; ?>" width="100%" alt="<?php the_title(); ?>" itemprop="thumbnailUrl">
      </div>
    <?php endif; ?>

    <div class="post-content<?php echo $pad_content; ?>" itemprop="text">
      <?php the_content(); ?>
    </div>
  </article>
</section>
