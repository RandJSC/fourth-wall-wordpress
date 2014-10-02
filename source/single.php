<?php
/**
 * Fourth Wall Events
 * Single Post Template
 */

get_header();

global $post;

if (isset($post) && fwe_is_post($post)) {
  $categories = get_the_category($post->ID);

  if (count($categories) > 0) {
    $main_cat = $categories[0];
    $banner   = get_term_meta($main_cat->term_id, 'banner_image', true);
  } else {
    // [todo] - Add default banner theme option and pull it in here.
  }
}
?>

<?php if (isset($banner)): ?>
  <section class="banner">
    <?php var_dump($banner); ?>
    <figure>
      <img src="" alt="">
      <figcaption></figcaption>
    </figure>
  </section>
<?php endif; ?>

<?php
get_footer();
?>
