<div id="comments" class="comments-area">
  <?php if (have_comments()): ?>
    <ol class="comment-list">
      <?php
      wp_list_comments(array(
        'style' => 'ol',
        'short_ping' => true,
        'avatar_size' => 56,
      ));
      ?>
    </ol>
  <?php endif; ?>
  <?php comment_form(); ?>
</div>
