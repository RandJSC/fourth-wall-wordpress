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
      <img src="<?php echo $banner[0]; ?>" alt="<?php echo $caption; ?>" width="100%">
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
  <?php
  $post_id        = get_the_ID();
  $team_member_id = get_post_meta($post_id, 'team_member_id', true);
  $post_tags      = get_the_tags();

  if (!empty($team_member_id)) {
    $team_member = get_post($team_member_id);
  }
  ?>
  <section id="main-page-content" class="content-section">
    <article <?php post_class(); ?>>
      <div class="post-header padded">
        <h1><?php the_title(); ?></h1>

        <?php if (!empty($team_member_id)): ?>
          <div class="byline">
            <span class="fa fa-user"></span>
            <a href="<?php echo get_permalink($team_member_id); ?>">Posted by <?php echo apply_filters('the_title', $team_member->post_title); ?></a>
          </div>
        <?php endif; ?>
      </div>

      <div class="post-date padded">
        <span class="fa fa-clock-o"></span>
        <?php the_date(); ?>
      </div>

      <?php if ($post_tags): ?>
        <div class="post-tags padded">
          <span class="fa fa-tags"></span>
          <?php fwe_tag_list($post_tags); ?>
        </div>
      <?php endif; ?>

      <div class="post-excerpt padded">
        <?php the_excerpt(); ?>
      </div>

      <?php if (has_post_thumbnail()): ?>
        <?php
        $thumb_id  = get_post_thumbnail_id();
        $thumb_src = wp_get_attachment_image_src($thumb_id, 'full');
        ?>
        <div class="post-featured-image">
          <img src="<?php echo $thumb_src[0]; ?>" width="100%" alt="<?php the_title(); ?>">
        </div>
      <?php endif; ?>

      <div class="post-content padded">
        <?php the_content(); ?>
      </div>
    </article>
  </section>
<?php endwhile; endif; ?>

<?php
get_footer();
?>
