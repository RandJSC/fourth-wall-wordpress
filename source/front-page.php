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
  ?>
    <section class="slider banner">
      <div class="slides">
        <?php foreach ($images['image'] as $idx => $id): ?>
          <?php
          $title    = $images['title'][$idx];
          $link_url = $images['link_url'][$idx];
          $src      = wp_get_attachment_image_src($images['image'][$idx][0], 'full');
          ?>
          <figure class="slide">
            <a href="<?php echo $link_url; ?>">
              <?php
              $img_src = ($idx === 0) ? ' src="' . $src[0] . '"' : '';
              $data_lazy = ($idx > 0) ? ' data-lazy="' . $src[0] . '"' : '';
              ?>
              <img<?php echo $img_src . $data_lazy; ?> alt="<?php echo $title; ?>" width="100%">
              <figcaption><?php echo $title; ?></figcaption>
            </a>
          </figure>
        <?php endforeach; ?>
      </div>
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
