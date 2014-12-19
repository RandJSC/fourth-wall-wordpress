<?php
/**
 * Fourth Wall Events
 * Single Case Study Template
 */

get_header();

global $post, $fwe_settings;
$banner_link = get_post_type_archive_link('case_study');

include(locate_template('partials/gallery-banner.php'));
include(locate_template('partials/gallery-quick-links.php'));
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <?php
  $post_id     = get_the_ID();
  $location    = get_post_meta($post_id, 'location_name', true);
  $date        = get_post_meta($post_id, 'event_date', true);
  $gallery_id  = get_post_meta($post_id, 'gallery_id', true);
  $photos      = get_post_meta($gallery_id, 'gallery_photos', true);
  $photo_count = count($photos['photo']);
  $categories  = get_the_terms($post_id, 'event_category');

  if ($date) {
    $date       = new DateTime($date);
    $event_date = $date->format('F j, Y');
  }
  ?>
  <section id="main-page-content" class="content-section case-study">
    <article itemscope itemtype="http://schema.org/WebPage" <?php post_class(); ?>>
      <div class="post-header padded">
        <h1 itemprop="headline"><?php the_title(); ?></h1>

        <div class="details" itemprop="recordedAt" itemscope itemtype="http://schema.org/Event">
          <?php if ($location): ?>
            <div class="location" itemprop="location" itemscope itemtype="http://schema.org/Place">
              <span class="fa fa-map-marker"></span>
              <span class="text" itemprop="name"><?php echo $location; ?></span>
            </div>
          <?php endif; ?>

          <?php if (isset($event_date)): ?>
            <div class="date">
              <span class="fa fa-clock-o"></span>
              <span class="text" itemprop="startDate"><?php echo $event_date; ?></span>
            </div>
          <?php endif; ?>

          <?php if (!empty($categories)): ?>
            <div class="category">
              <span class="fa fa-tag"></span>
              <span class="text">
                <?php echo fwe_term_links($categories); ?>
              </span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="post-excerpt padded" itemprop="about">
        <?php the_excerpt(); ?>
      </div>

      <div class="gallery-images">
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

      <div class="post-content padded" itemprop="text">
        <?php the_content(); ?>
      </div>

      <?php include(locate_template('partials/single-pagination.php')); ?>
    </article>
  </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
