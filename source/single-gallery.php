<?php
/**
 * Fourth Wall Events
 * Single Gallery Template
 */

get_header();

global $post, $fwe_settings;

$has_banner = array_key_exists('where_weve_been_banner', $fwe_settings) && !empty($fwe_settings['where_weve_been_banner']);

if ($has_banner) {
  $banner = wp_get_attachment_image_src($fwe_settings['where_weve_been_banner'], 'full');
  $banner_link = get_post_type_archive_link('gallery');
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
  $case_study  = get_post_meta($post_id, 'case_study_id', true);
  $photos      = get_post_meta($post_id, 'gallery_photos', true);
  $photo_count = count($photos['photo']);

  if ($date) {
    $date       = new DateTime($date);
    $event_date = $date->format('F j, Y');
  }

  if ($case_study) {
    $case_study_link = get_permalink($case_study);
  }
  ?>
  <section id="main-page-content" class="content-section gallery">
    <article <?php post_class(); ?>>
      <div class="post-header padded">
        <h1><?php the_title(); ?></h1>

        <div class="details">
          <?php if ($location): ?>
            <div class="location">
              <span class="fa fa-map-marker"></span>
              <?php echo $location; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($event_date)): ?>
            <div class="date">
              <span class="fa fa-clock-o"></span>
              <?php echo $event_date; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="post-content padded">
        <?php the_content(); ?>
      </div>

      <div class="gallery-images">
        <?php if ($case_study): ?>
          <div class="case-study-link">
            <a href="<?php echo $case_study_link; ?>">
              Read the Case Study
              <span class="fa fa-arrow-right"></span>
            </a>
          </div>
        <?php endif; ?>

        <div class="gallery-slider">
          <div class="slides">
            <?php for ($i = 0; $i < $photo_count; $i++): ?>
              <?php
              list($src, $width, $height, $resized) = wp_get_attachment_image_src($photos['photo'][$i][0], 'full');
              $src_attr = fwe_lazy_load_img_src($src, $i);
              ?>
              <figure class="slide">
                <a href="<?php echo $src; ?>">
                  <img <?php echo $src_attr; ?> width="100%" alt="<?php echo $photos['title'][$i]; ?>">
                </a>
              </figure>
            <?php endfor; ?>
          </div>
        </div>
      </div>

      <div class="pagination">
        <?php
        $prev_post      = get_adjacent_post();
        $next_post      = get_adjacent_post(false, '', false);
        $prev_post_link = $prev_post ? get_permalink($prev_post->ID) : '';
        $next_post_link = $next_post ? get_permalink($next_post->ID) : '';
        ?>
        <a class="previous" href="<?php echo $prev_post_link; ?>">
          <?php if ($prev_post): ?>
            <span class="arrow">
              <span class="fa fa-arrow-left"></span>
            </span>
            <span class="link-text">
              Prev
            </span>
          <?php endif; ?>

          <a class="next" href="<?php echo $next_post_link; ?>">
            <?php if ($next_post): ?>
              <span class="link-text">
                Next
              </span>
              <span class="arrow">
                <span class="fa fa-arrow-right"></span>
              </span>
            <?php endif; ?>
          </a>
        </a>
      </div>
    </article>
  </section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
