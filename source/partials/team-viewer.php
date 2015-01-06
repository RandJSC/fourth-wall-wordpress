<?php
$count = 0;
?>
<div class="team-members">
  <?php if ($team_members->have_posts()): ?>

    <?php // Current active team member area ?>
    <?php $team_members->the_post(); ?>
    <?php
    $id          = get_the_ID();
    $job_title   = get_post_meta($id, 'job_title', true);
    $location    = get_post_meta($id, 'location', true);
    $facebook    = get_post_meta($id, 'facebook', true);
    $twitter     = get_post_meta($id, 'twitter', true);
    $instagram   = get_post_meta($id, 'instagram', true);
    $linkedin    = get_post_meta($id, 'linkedin', true);
    $pinterest   = get_post_meta($id, 'pinterest', true);
    $google_plus = get_post_meta($id, 'google_plus', true);
    $email       = get_post_meta($id, 'email_address', true);
    $first_name  = get_post_meta($id, 'given_name', true);
    ?>
    <div class="team-member-viewer" data-visible="true">
      <div class="fade-wrap visible">
        <div class="button-row">
          <a href="" class="collapse-button">
            <span class="fa fa-remove"></span>
          </a>
        </div>

        <div class="team-member-detail">
          <?php if (has_post_thumbnail()): ?>
            <div class="team-member-photo">
              <?php the_post_thumbnail('team-member-headshot'); ?>
            </div>
          <?php endif; ?>

          <div class="team-member-content">
            <h3><?php the_title(); ?></h3>

            <div class="title-location">
              <span class="title">
                <?php echo $job_title; ?>
              </span>
              &ndash;
              <span class="location">
                <?php echo $location; ?>
              </span>
            </div>

            <?php the_content(); ?>

            <ul class="contact">
              <?php if ($facebook): ?>
                <li>
                  <a href="<?php echo esc_url($facebook); ?>">
                    <span class="fa fa-facebook"></span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($twitter): ?>
                <li>
                  <a href="<?php echo esc_url($twitter); ?>">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($instagram): ?>
                <li>
                  <a href="<?php echo esc_url($instagram); ?>">
                    <span class="fa fa-instagram"></span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($linkedin): ?>
                <li>
                  <a href="<?php echo esc_url($linkedin); ?>">
                    <span class="fa fa-linkedin"></span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($pinterest): ?>
                <li>
                  <a href="<?php echo esc_url($pinterest); ?>">
                    <span class="fa fa-pinterest"></span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($google_plus): ?>
                <li>
                  <a href="<?php echo esc_url($google_plus); ?>">
                    <span class="fa fa-google-plus"></span>
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($email): ?>
                <li>
                  <a href="mailto:<?php echo $email; ?>">
                    <span class="fa fa-envelope"></span>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

      </div>
    </div>
    <div class="get-talking">
      <?php if ($first_name): ?>
        get <?php echo $first_name; ?> talking
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <ul class="team-thumbs">
    <?php
    $team_members->rewind_posts();
    $count      = 0;
    $colors     = array(
      'blue',
      'pink',
      'orange',
      'green',
    );
    $num_colors = count($colors);

    while ($team_members->have_posts()): $team_members->the_post();
      global $post;

      $color_idx = $count % $num_colors;
      $color     = $colors[$color_idx];
      $job_title = get_post_meta(get_the_ID(), 'job_title', true);
    ?>
      <?php if (has_post_thumbnail()): ?>
        <?php
        $thumb = get_post_thumbnail_id();
        $thumb = wp_get_attachment_image_src($thumb);
        ?>
        <li class="<?php echo $color; ?>">
          <a class="team-member"
            href="<?php echo site_url('/wp-json/fwe/team-members/' . get_the_ID()); ?>"
            data-slug="<?php echo esc_attr($post->post_name); ?>"
            style="background-image:url('<?php echo $thumb[0]; ?>')">

            <div class="name-title <?php echo $color; ?>">
              <strong class="team-member-name">
                <?php the_title(); ?>
              </strong>
              <span class="team-member-title">
                <?php echo $job_title; ?>
              </span>
            </div>
          </a>
        </li>
      <?php endif; ?>
      <?php $count++; ?>
    <?php endwhile; ?>
  </ul>
  <?php wp_reset_postdata(); ?>
</div>
