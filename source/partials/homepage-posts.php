<?php
global $post;

$post_id   = get_the_ID();
$has_thumb = has_post_thumbnail();
$li_class  = $has_thumb ? '' : ' class="no-thumb"';
$permalink = get_permalink($post_id);
$raw_date  = get_the_date('Y-m-d H:i');
$post_date = get_the_date('F j, Y');
?>
<li<?php echo $li_class; ?>>
  <?php if ($has_thumb): ?>
    <a href="<?php echo $permalink; ?>" class="thumb">
      <?php the_post_thumbnail('tiny-thumb'); ?>
    </a>
  <?php endif; ?>

  <div class="float">
    <a href="<?php echo $permalink; ?>" class="title">
      <?php the_title(); ?>
    </a>

    <div class="show-desktop">
      <div class="date">
        <span class="fa fa-clock-o"></span>
        <time datetime="<?php echo $raw_date; ?>">
          <?php echo $post_date; ?>
        </time>
      </div>

      <div class="excerpt">
        <?php the_excerpt(); ?>
      </div>
    </div>
  </div>
</li>
