<?php
global $fwe_settings;

$page_id       = $stitch['stitch_page']->ID;
$path          = fwe_relative_url(get_permalink($page_id));
$backgrounds   = get_post_meta($page_id, 'page_backgrounds', true);
$backgrounds   = fwe_build_page_background_object($backgrounds);
$bg_data       = '';
$section_style = '';
$content_style = '';
$slider_speed  = fwe_theme_option_exists('global_slider_speed') ? $fwe_settings['global_slider_speed'] : 8;

if (!empty($backgrounds)) {
  $bg_data       = !empty($backgrounds) ? ' data-backgrounds="' . htmlspecialchars(json_encode($backgrounds)) . '"' : '';
  $first_bg      = $backgrounds[0];
  $section_style = fwe_style_attribute(array(
    'background-image'    => "url({$first_bg['backgroundImage']})",
    'background-size'     => $first_bg['backgroundSize'],
    'background-position' => $first_bg['backgroundPosition'],
    'background-repeat'   => $first_bg['backgroundRepeat'],
  ), true);
  $content_style = fwe_style_attribute(array(
    'color'            => $first_bg['textColor'],
    'background-color' => fwe_hex_to_rgba($first_bg['backgroundColor'], $first_bg['colorOpacity']),
  ), true);
}
?>
<section
  <?php echo $bg_data; ?><?php echo $section_style; ?>
  class="stitch content-section"
  id="<?php echo $stitch['stitch_page']->post_name; ?>"
  data-slug="<?php echo $stitch['stitch_page']->post_name; ?>"
  data-url="<?php echo $path; ?>">

  <article class="stitch">
    <div class="post-header<?php echo $stitch['pad_header']; ?><?php echo $stitch['white_header']; ?>">
      <h2><?php echo apply_filters('the_title', $stitch['stitch_page']->post_title); ?></h2>
    </div>

    <?php if ($stitch['has_slides']): ?>
      <div class="stitch-slider">
        <div class="slides" data-speed="<?php echo esc_attr($slider_speed); ?>">
          <?php for ($i = 0; $i < $stitch['slide_count']; $i++): ?>
            <?php
            $title    = $stitch['slider_images']['title'][$i];
            $link_url = $stitch['slider_images']['link_url'][$i];
            $image    = fwe_get_first_valid_image($stitch['slider_images']['image'][$i]);
            $image    = wp_get_attachment_image_src($image, 'full');
            $src_attr = fwe_lazy_load_img_src($image[0], $i);
            ?>
            <figure class="slide">
              <a href="<?php echo esc_url($image[0]); ?>">
                <img <?php echo $src_attr; ?> alt="<?php echo $title; ?>" width="100%">
              </a>
            </figure>
          <?php endfor; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="post-content<?php echo $stitch['pad_content']; ?><?php echo ' ' . $stitch['stitch_page']->post_name; ?>"<?php echo $content_style; ?>>
      <?php echo $stitch['stitch_content']; ?>
    </div>
  </article>
</section>
