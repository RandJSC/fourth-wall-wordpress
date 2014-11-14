<?php if ($team_members->have_posts()): while ($team_members->have_posts()): ?>
  <?php
  $team_members->the_post();
  ?>
<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>
