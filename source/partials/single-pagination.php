<div class="pagination">
  <div class="pagination-internal">
    <?php
    $prev_post      = get_adjacent_post();
    $next_post      = get_adjacent_post(false, '', false);
    $prev_post_link = $prev_post ? get_permalink($prev_post->ID) : '';
    $next_post_link = $next_post ? get_permalink($next_post->ID) : '';
    ?>
    <a class="previous" href="<?php echo $prev_post_link; ?>">
      <?php if ($prev_post): ?>
        <span class="arrow">
          <span class="fa fa-arrow-left"></span>
        </span>
        <span class="link-text">
          Prev
        </span>
      <?php endif; ?>
    </a>

    <a class="next" href="<?php echo $next_post_link; ?>">
      <?php if ($next_post): ?>
        <span class="link-text">
          Next
        </span>
        <span class="arrow">
          <span class="fa fa-arrow-right"></span>
        </span>
      <?php endif; ?>
    </a>
  </div>
</div>
