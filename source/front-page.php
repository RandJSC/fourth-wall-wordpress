<?php
/**
 * Fourth Wall Events
 * Homepage Template
 */

get_header();

global $fwe_settings;
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  $post_id      = get_the_ID();
  $images       = get_post_meta($post_id, 'slider_images', true);
  $image_count  = count($images['image']);
  $stitches     = get_post_meta($post_id, 'stitch_children');
  $stitches     = array_filter($stitches, function($item) {
    return !empty($item);
  });
  $has_stitches = is_array($stitches) && count($stitches);

  if (array_key_exists('homepage_slider_speed', $fwe_settings)) {
    $slider_speed_attr = ' data-autoplay-speed="' . $fwe_settings['homepage_slider_speed'] . '"';
  } else {
    $slider_speed_attr = '';
  }

  if ($image_count):
  ?>
    <section class="slider banner home">
      <div class="slides"<?php echo $slider_speed_attr; ?>>
        <?php for ($i = 0; $i < $image_count; $i++): ?>
          <?php
          $title      = $images['title'][$i];
          $link_url   = esc_url($images['link_url'][$i]);
          $link_blank = empty($link_url) || $link_url == '#';
          $img_id     = fwe_get_first_valid_image($images['image'][$i]);
          $src        = wp_get_attachment_image_src($img_id, 'homepage-slider');
          ?>
          <figure class="slide">
            <?php if (!$link_blank): ?>
              <a href="<?php echo $link_url; ?>">
            <?php endif; ?>
              <?php
              $img_src = fwe_lazy_load_img_src($src[0], $i);
              ?>
              <img <?php echo $img_src; ?> alt="<?php echo esc_attr($title); ?>" width="100%">
              <figcaption><?php echo $title; ?></figcaption>
            <?php if (!$link_blank): ?>
              </a>
            <?php endif; ?>
            </a>
          </figure>
        <?php endfor; ?>
      </div>
    </section>
  <?php endif; ?>

  <section id="quick-links" class="home">
    <?php
    wp_nav_menu(array(
      'theme_location' => 'quick_links',
      'container'      => 'nav',
      'fallback_cb'    => false,
      'walker'         => new Walker_FWE_QuickLinks(),
      'link_before'    => '<span class="text">',
      'link_after'     => '</span>',
    ));
    ?>
  </section>

  <section id="main-page-content" class="content-section padded home">
    <div class="post-top">
      <?php include(locate_template('partials/sharing-link.php')); ?>
    </div>

    <h1><?php the_title(); ?></h1>

    <?php the_content(); ?>
  </section>

  <?php
  if ($has_stitches) {
    foreach ($stitches as $stitch_id) {
      $stitch = fwe_get_stitch_vars($stitch_id);
      include locate_template('partials/subpage-stitch-content.php');
    }
    wp_reset_postdata();
  }
  ?>
<?php endwhile; endif; ?>

<?php
$blog_args = array(
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => 3,
  'category_name'  => 'blog',
  'orderby'        => 'date',
  'order'          => 'DESC',
);
$blog_query = new WP_Query($blog_args);
$blog_link  = get_term_link('blog', 'category');

if ($blog_query->have_posts()):
?>
  <section id="blog-posts" class="content-section bg green">
    <div class="section-inner">
      <h2>
        <a href="<?php echo $blog_link; ?>">Blog Posts</a>
      </h2>

      <ul class="thumb-list">
        <?php while ($blog_query->have_posts()): $blog_query->the_post(); ?>
          <?php include(locate_template('partials/homepage-posts.php')); ?>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
    </div>
  </section>

<?php endif; ?>

<?php
$news_args  = $blog_args;
$news_args['category_name'] = 'news';
$news_query = new WP_Query($news_args);
$news_link  = get_term_link('news', 'category');

if ($news_query->have_posts()):
?>
  <section id="news-posts" class="content-section bg-none">
    <div class="section-inner">
      <h2>
        <a href="<?php echo $news_link; ?>">News</a>
      </h2>

      <ul class="thumb-list">
        <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
          <?php include(locate_template('partials/homepage-posts.php')); ?>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
    </div>
  </section>
<?php endif; ?>

<?php include(locate_template('partials/email-signup.php')); ?>
<?php include(locate_template('partials/facebook-feed.php')); ?>

<?php get_footer(); ?>
