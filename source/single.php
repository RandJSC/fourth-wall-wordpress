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
  $caption        = get_term_meta($categories[0]->term_id, 'banner_caption', true);
  $caption        = !empty($caption) ? $caption : $categories[0]->name;
  $banner_classes = 'post';

  include(locate_template('partials/generic-banner.php'));
  ?>
<?php endif; ?>

<?php include(locate_template('partials/post-quick-links.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  global $post;
  $post_id        = $post->ID;
  $team_member_id = get_post_meta($post_id, 'team_member_id', true);
  $post_tags      = get_the_tags();
  $author_id      = $post->post_author;
  $google_plus    = get_user_meta($author_id, 'googleplus', true);
  ?>
  <section id="main-page-content" class="content-section" itemscope itemtype="http://schema.org/BlogPosting">

    <article <?php post_class(); ?>>
      <div class="post-header padded">
        <div class="post-top single">
          <?php include(locate_template('partials/breadcrumbs.php')); ?>
          <?php include(locate_template('partials/sharing-link.php')); ?>
        </div>

        <h1 itemprop="headline"><?php the_title(); ?></h1>

        <div class="byline">
          <span class="fa fa-user"></span>
          <a rel="me" href="<?php echo $google_plus; ?>" target="_blank">Posted by <?php the_author(); ?></a>
        </div>
      </div>

      <div class="post-date padded">
        <span class="fa fa-clock-o"></span>
        <time itemprop="datePublished" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date(); ?></time>
      </div>

      <?php if ($post_tags): ?>
        <div class="post-tags padded">
          <span class="fa fa-tags"></span>
          <?php fwe_tag_list($post_tags); ?>
        </div>
      <?php endif; ?>

      <div class="post-excerpt padded" itemprop="description">
        <?php the_excerpt(); ?>
      </div>

      <?php if (has_post_thumbnail()): ?>
        <?php
        $thumb_id  = get_post_thumbnail_id();
        $thumb_src = wp_get_attachment_image_src($thumb_id, 'full');
        ?>
        <div class="post-featured-image">
          <img src="<?php echo $thumb_src[0]; ?>" width="100%" alt="<?php the_title(); ?>" itemprop="thumbnailUrl">
        </div>
      <?php endif; ?>

      <div class="post-content padded" itemprop="articleBody">
        <?php the_content(); ?>
      </div>
    </article>
  </section>
<?php endwhile; endif; ?>

<?php
get_footer();
?>
