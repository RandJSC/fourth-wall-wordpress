<div class="testimonial-slider">
  <div class="quotes">
    <div class="quote left">&ldquo;</div>
    <div class="quote right">&rdquo;</div>
  </div>
  <ul class="testimonials">
    <?php while ($query->have_posts()): $query->the_post(); ?>
      <?php
      $post_id      = get_the_ID();
      $author_name  = get_post_meta($post_id, 'author_name', true);
      $author_title = get_post_meta($post_id, 'author_position', true);
      ?>
      <li <?php post_class(); ?>>
        <blockquote>
          <?php the_content(); ?>

          <footer>
            <cite>
              &ndash;&nbsp;<?php echo $author_name; ?>
              <br>
              <em><?php echo $author_title; ?></em>
            </cite>
          </footer>
        </blockquote>
      </li>
    <?php endwhile; wp_reset_postdata(); ?>
  </ul>
  <div class="dot-nav">
    <?php for ($i = 0; $i < $total_posts; $i++): ?>
      <?php $current = ($i === 0) ? ' current' : ''; ?>
      <a class="slider-dot<?php echo $current; ?>" href="" data-index="<?php echo $i; ?>"></a>
    <?php endfor; ?>
  </div>
</div>
