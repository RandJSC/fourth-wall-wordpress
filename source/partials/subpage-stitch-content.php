<?php
$path = fwe_relative_url(get_permalink($stitch['stitch_page']->ID));
?>
<section
  class="stitch content-section"
  data-slug="<?php echo $stitch['stitch_page']->post_name; ?>"
  data-url="<?php echo $path; ?>"<?php echo $stitch['section_style']; ?>>

  <article class="stitch">
    <div class="post-header<?php echo $stitch['pad_header']; ?><?php echo $stitch['white_header']; ?>">
      <h2><?php echo apply_filters('the_title', $stitch['stitch_page']->post_title); ?></h2>
    </div>

    <?php if ($stitch['has_slides']): ?>
      <div class="stitch-slider">
        <div class="slides">
          <?php for ($i = 0; $i < $stitch['slide_count']; $i++): ?>
            <?php
            $title    = $stitch['slider_images']['title'][$i];
            $link_url = $stitch['slider_images']['link_url'][$i];
            $image    = $stitch['slider_images']['image'][$i][0];
            $image    = wp_get_attachment_image_src($image, 'full');
            $src_attr = fwe_lazy_load_img_src($image[0], $i);
            ?>
            <figure class="slide">
              <a href="<?php echo esc_url($link_url); ?>">
                <img <?php echo $src_attr; ?> alt="<?php echo $title; ?>" width="100%">
              </a>
            </figure>
          <?php endfor; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="post-content<?php echo $stitch['pad_content']; ?>"<?php echo $stitch['content_style']; ?>>
      <?php echo $stitch['stitch_content']; ?>
    </div>
  </article>
</section>
