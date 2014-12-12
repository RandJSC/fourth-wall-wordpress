<div class="gallery-results">
  <?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>
      <div class="result">
        <div class="thumbnail">
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()): ?>
              <?php the_post_thumbnail('tiny-thumb'); ?>
            <?php else: ?>
              <?php
              $post_id   = get_the_ID();
              $post_type = get_post_type($post_id);

              if ($post_type === 'gallery') {
                $photos  = get_post_meta($post_id, 'gallery_photos', true);
              } else {
                $gallery = get_post_meta($post_id, 'gallery_id', true);
                $photos  = get_post_meta($gallery, 'gallery_photos', true);
              }

              if (is_array($photos) && array_key_exists('photo', $photos) && count($photos['photo'])):
                $thumb = $photos['photo'][0][0];
                $thumb = wp_get_attachment_image_src($thumb, 'tiny-thumb');
              ?>
                <img src="<?php echo $thumb[0]; ?>" width="<?php echo $thumb[1]; ?>" height="<?php echo $thumb[2]; ?>" alt="<?php the_title(); ?>">
              <?php endif; ?>
            <?php endif; ?>
          </a>
        </div>
        <div class="title">
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
          <div class="show-desktop">
            <div class="date">
              <span class="fa fa-clock-o"></span>
              <span class="text"><?php echo get_the_date(); ?></span>
            </div>
            <div class="excerpt">
              <?php the_excerpt(); ?>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>
      <em class="no-results">No results found.</em>
    </p>
  <?php endif; ?>
</div>
