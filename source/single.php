<?php
/**
 * Fourth Wall Events
 * Single Post Template
 */

get_header();

global $post, $fwe_settings;

if (isset($post) && fwe_is_post($post)) {
  $categories = get_the_category($post->ID);

  if (count($categories) > 0) {
    $banner = get_term_meta($categories[0]->term_id, 'banner_image', true);
  } else {
    $banner = $fwe_settings['default_category_banner'];
  }

  $banner = $banner ? $banner : $fwe_settings['default_category_banner'];
  $banner = wp_get_attachment_image_src($banner, 'full');
}
?>

<?php if ($banner): ?>
  <?php
  $caption = get_term_meta($categories[0]->term_id, 'banner_caption', true);
  $caption = !empty($caption) ? $caption : $categories[0]->name;
  ?>
  <section class="banner">
    <figure id="page-banner">
      <img src="<?php echo $banner[0]; ?>" alt="<?php echo $caption; ?>">
      <figcaption><?php echo $caption; ?></figcaption>
    </figure>
  </section>
<?php endif; ?>

<section id="quick-links" class="posts">
  <?php
  wp_nav_menu(array(
    'theme_location' => 'post_quick_links',
    'container'      => 'nav',
    'fallback_cb'    => false,
    'walker'         => new Walker_FWE_QuickLinks(),
  ));
  ?>
</section>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <section id="main-page-content" class="content-section padded">
    <h1><?php the_title(); ?></h1>

    <?php the_content(); ?>
  </section>
<?php endwhile; endif; ?>

<?php
get_footer();
?>
