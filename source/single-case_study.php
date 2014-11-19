<?php
/**
 * Fourth Wall Events
 * Single Case Study Template
 */

get_header();

global $post, $fwe_settings;

$has_banner = array_key_exists('where_weve_been_banner', $fwe_settings) && !empty($fwe_settings['where_weve_been_banner']);

if ($has_banner) {
  $banner = wp_get_attachment_image_src($fwe_settings['where_weve_been_banner'], 'full');
  $banner_link = get_post_type_archive_link('case-study');
}
?>

<?php if ($has_banner): ?>
  <section class="banner">
    <figure id="page-banner">
      <a href="<?php echo $banner_link; ?>">
        <img src="<?php echo $banner[0]; ?>" alt="Where We've Been" width="100%">
        <figcaption>Where We've Been</figcaption>
      </a>
    </figure>
  </section>
<?php endif; ?>

<section id="quick-links" class="gallery">
  <?php
  wp_nav_menu(array(
    'theme_location' => 'gallery_quick_links',
    'container'      => 'nav',
    'fallback_cb'    => false,
    'walker'         => new Walker_FWE_QuickLinks(),
  ));
  ?>
</section>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <?php
  $post_id     = get_the_ID();
  $location    = get_post_meta($post_id, 'location_name', true);
  $date        = get_post_meta($post_id, 'event_date', true);
  $gallery_id  = get_post_meta($post_id, 'gallery_id', true);
  $photos      = get_post_meta($gallery_id, 'gallery_photos', true);
  $photo_count = count($photos['photo']);

  if ($date) {
    $date       = new DateTime($date);
    $event_date = $date->format('F j, Y');
  }
  ?>
  <section id="main-page-content" class="content-section case-study">
    <article <?php post_class(); ?>>
      <div class="post-header padded">
        <h1><?php the_title(); ?></h1>

        <div class="details">
          <?php if ($location): ?>
            <div class="location">
              <span class="fa fa-map-marker"></span>
              <span class="text"><?php echo $location; ?></span>
            </div>
          <?php endif; ?>

          <?php if (isset($event_date)): ?>
            <div class="date">
              <span class="fa fa-clock-o"></span>
              <span class="text"><?php echo $event_date; ?></span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="post-content padded">
        <?php the_content(); ?>
      </div>
    </article>
  </section>

<?php endwhile; endif; ?>
