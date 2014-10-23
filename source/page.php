<?php
get_header();

global $post, $fwe_settings;
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <h1><?php the_title(); ?></h1>

  <?php the_content(); ?>

  <?php
  $images = get_post_meta(get_the_ID(), 'slider_images', true);

  if (!empty($images) && !empty($images['image'][0][0])) {
    var_dump($images);
    foreach ($images['image'] as $idx => $img) {
      $src = wp_get_attachment_image_src($img[0], 'full');
      echo '<img src="' . $src[0] . '">';
    }
  }
  ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
