<?php
get_header();

global $post, $fwe_settings, $banner;

$banner = fwe_get_page_banner($post->ID);
?>

<?php get_template_part('subpage', 'banner'); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
  <?php
  // Fetch the pages whose stitch_content should be pulled into this one:
  $post_id  = get_the_ID();
  $stitches = get_post_meta($post_id, 'stitch_children');
  $stitches = array_filter($stitches, function($item) {
    return !empty($item);
  });
  ?>

  <?php // This page's content: ?>
  <?php get_template_part('subpage', 'main-content'); ?>

  <?php
  // Stitched subpage content (if any):

  if (is_array($stitches) && count($stitches)):
    foreach ($stitches as $stitch_id):
      $stitch_page    = get_post($stitch_id);
      $stitch_content = get_post_meta($stitch_id, 'stitch_content', true);
      $stitch_content = apply_filters('the_content', $stitch_content);
      $bg_image       = get_post_meta($stitch_id, 'background_image', true);
      $bg_color       = get_post_meta($stitch_id, 'background_color', true);
      $bg_size        = get_post_meta($stitch_id, 'background_size', true);
      $bg_pos         = get_post_meta($stitch_id, 'background_position', true);
      $bg_repeat      = get_post_meta($stitch_id, 'background_repeat', true);

      $pad_content    = get_post_meta($stitch_id, 'pad_content', true);
      $pad_content    = ($pad_content === 'no') ? false : true;
      $pad_content    = $pad_content ? ' padded' : '';

      $pad_header     = get_post_meta($stitch_id, 'pad_header', true);
      $pad_header     = ($pad_header === 'no') ? false : true;
      $pad_header     = $pad_header ? ' padded' : '';

      $section_style  = fwe_style_attribute(array(
        'background-image'    => $bg_image,
        'background-size'     => $bg_size,
        'background-position' => $bg_pos,
        'background-repeat'   => $bg_repeat,
      ));
      $article_style  = fwe_style_attribute(array(
        'background-color' => $bg_color,
      ));
  ?>
      <section
        class="stitch content-section"
        data-slug="<?php echo $stitch_page->post_name; ?>"
        data-url="<?php echo get_permalink($stitch_id); ?>"<?php echo $section_style; ?>>

        <article class="stitch"<?php echo $article_style; ?>>
          <div class="post-header<?php echo $pad_header; ?>">
            <h2><?php echo apply_filters('the_title', $stitch_page->post_title); ?></h2>
          </div>

          <div class="post-content<?php echo $pad_content; ?>">
            <?php echo $stitch_content; ?>
          </div>
        </article>
      </section>
  <?php
    endforeach;
    wp_reset_postdata();
  endif;
  ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
