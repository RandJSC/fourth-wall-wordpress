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
      $bg_image       = wp_get_attachment_image_src($bg_image, 'full');
      $bg_image       = $bg_image[0];
      $bg_image       = !empty($bg_image) ? 'url(\'' . $bg_image . '\')' : null;
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
      $content_style  = fwe_style_attribute(array(
        'background-color' => $bg_color,
      ));

      $white_header   = $bg_image ? ' white' : '';

      $slider_images  = get_post_meta($stitch_id, 'slider_images', true);
      $has_slides     = !empty($slider_images) && !empty($slider_images['image'][0][0]);
      $slide_count    = $has_slides ? count($slider_images['image']) : 0;
  ?>
      <section
        class="stitch content-section"
        data-slug="<?php echo $stitch_page->post_name; ?>"
        data-url="<?php echo get_permalink($stitch_id); ?>"<?php echo $section_style; ?>>

        <article class="stitch">
          <div class="post-header<?php echo $pad_header; ?><?php echo $white_header; ?>">
            <h2><?php echo apply_filters('the_title', $stitch_page->post_title); ?></h2>
          </div>

          <?php if ($has_slides): ?>
            <div class="stitch-slider">
              <div class="slides">
                <?php for ($i = 0; $i < $slide_count; $i++): ?>
                  <figure class="slide">

                  </figure>
                <?php endfor; ?>
              </div>
            </div>
          <?php endif; ?>

          <div class="post-content<?php echo $pad_content; ?>"<?php echo $content_style; ?>>
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
