<?php
/**
 * Fourth Wall Events
 * Homepage Template
 */

get_header();
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  $images = get_post_meta(get_the_ID(), 'slider_images', true);
  $has_slides = !empty($images) && !empty($images['image'][0][0]);

  if ($has_slides):
    var_dump($images);
  ?>
    <section class="slider banner">

    </section>
  <?php endif; ?>

  <section id="quick-links">
    <?php
    wp_nav_menu(array(
      'theme_location' => 'quick_links',
      'container'      => 'nav',
      'fallback_cb'    => false,
      'walker'         => new Walker_FWE_QuickLinks(),
    ));
    ?>
  </section>

  <section id="main-page-content">
    <h1><?php the_title(); ?></h1>

    <?php the_content(); ?>
  </section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
