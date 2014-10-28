<?php
/**
 * Fourth Wall Events
 * Homepage Template
 */

get_header();
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  $post_id    = get_the_ID();
  $images     = get_post_meta($post_id, 'slider_images', true);
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
              $img_src = ($idx === 0) ? ' src="' . $src[0] . '"' : 'data-lazy="' . $src[0] . '"';
              ?>
              <img<?php echo $img_src; ?> alt="<?php echo $title; ?>" width="100%">
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

  <section id="main-page-content" class="content-section padded">
    <h1><?php the_title(); ?></h1>

    <?php the_content(); ?>
  </section>
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
          <?php
          $blog_id   = get_the_ID();
          $has_thumb = has_post_thumbnail();
          $li_class  = $has_thumb ? '' : ' class="no-thumb"';
          $permalink = get_permalink($blog_id);
          ?>
          <li<?php echo $li_class; ?>>
            <?php if ($has_thumb): ?>
              <a href="<?php echo $permalink; ?>" class="thumb">
                <?php the_post_thumbnail('tiny-thumb'); ?>
              </a>
            <?php endif; ?>
            <a href="<?php echo $permalink; ?>">
              <?php the_title(); ?>
            </a>
          </li>
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
          <?php
          $news_id   = get_the_ID();
          $has_thumb = has_post_thumbnail();
          $li_class  = $has_thumb ? '' : ' class="no-thumb"';
          $permalink = get_permalink($news_id);
          ?>
          <li<?php echo $li_class; ?>>
            <?php if ($has_thumb): ?>
              <a href="<?php echo $permalink; ?>" class="thumb">
                <?php the_post_thumbnail('tiny-thumb'); ?>
              </a>
            <?php endif; ?>
            <a href="<?php echo $permalink; ?>">
              <?php the_title(); ?>
            </a>
          </li>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
    </div>
  </section>
<?php endif; ?>

<?php get_template_part('email-signup'); ?>

<?php get_template_part('facebook-feed'); ?>

<?php get_footer(); ?>
