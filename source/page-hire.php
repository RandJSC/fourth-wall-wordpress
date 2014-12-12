<?php
/*
Template Name: Hire Us
*/

get_header();

global $post, $fwe_settings;

$banner = fwe_get_page_banner($post->ID);
?>

<?php include(locate_template('partials/subpage-banner.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <section id="main-page-content" class="content-section">
    <article itemscope itemtype="http://schema.org/WebPage" <?php post_class('hire-us'); ?>>

      <div class="post-header">
        <h1 itemprop="headline"><?php the_title(); ?></h1>
        <hr>
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

      <div class="post-content" itemprop="text">
        <?php the_content(); ?>
      </div>

      <?php if (array_key_exists('hire_us_form_id', $fwe_settings) && $fwe_settings['hire_us_form_id']): ?>
        <div id="hire-form" class="post-content">
          <?php
          $form = GFAPI::get_form($fwe_settings['hire_us_form_id']);
          var_dump($form);
          ?>
        </div>
      <?php endif; ?>

    </article>
  </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
