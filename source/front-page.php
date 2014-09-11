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

if ($blog_query->have_posts()):
?>
  <section id="blog-posts" class="content-section bg-green">
    <h2>Blog Posts</h2>

    <ul class="thumb-list">
      <?php while ($blog_query->have_posts()): $blog_query->the_post(); ?>
        <?php
        $has_thumb = has_post_thumbnail();
        $li_class  = $has_thumb ? '' : ' class="no-thumb"';
        $permalink = get_permalink(get_the_ID());
        ?>
        <li<?php echo $li_class; ?>>
          <?php if ($has_thumb): ?>
            <a href="<?php echo $permalink; ?>">
              <?php the_post_thumbnail('tiny-thumb'); ?>
            </a>
          <?php endif; ?>
          <a href="<?php echo $permalink; ?>">
            <?php the_title(); ?>
          </a>
        </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  </section>
<?php endif; ?>

<?php
$news_args = $blog_args;
$news_args['category_name'] = 'news';
$news_query = new WP_Query($news_args);

if ($news_query->have_posts()):
?>
  <section id="news-posts" class="content-section bg-none">
    <h2>News</h2>

    <ul class="thumb-list">
      <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
        <?php
        $has_thumb = has_post_thumbnail();
        $li_class  = $has_thumb ? '' : ' class="no-thumb"';
        $permalink = get_permalink(get_the_ID());
        ?>
        <li<?php echo $li_class; ?>>
          <?php if ($has_thumb): ?>
            <a href="<?php echo $permalink; ?>">
              <?php the_post_thumbnail('tiny-thumb'); ?>
            </a>
          <?php endif; ?>
          <a href="<?php echo $permalink; ?>">
            <?php the_title(); ?>
          </a>
        </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  </section>
<?php endif; ?>

<section id="email-signup" class="content-section bg-blue">
  <div class="section-inner">
    <h2>Email Signup</h2>

    <p>
      Test test 123.
    </p>

    <form action="" method="post">
      <p>
        <input type="text" name="name" placeholder="Your Name" required>
      </p>
      <p>
        <input type="email" name="email" placeholder="Email Address" required>
      </p>
      <button type="submit" class="fwe-button">
        Submit &raquo;
      </button>
    </form>
  </div>
</section>

<?php get_footer(); ?>
