<div class="post-results">
  <?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>
      <div class="result">
        <div class="thumbnail">
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()): ?>
              <?php the_post_thumbnail('tiny-thumb'); ?>
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
