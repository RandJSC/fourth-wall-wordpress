<?php
/*
Template Name: Hire Us
*/

get_header();

global $post, $fwe_settings;

$banner = fwe_get_page_banner($post->ID);
?>

<?php include(locate_template('partials/subpage-banner.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <section id="main-page-content" class="content-section hire-us">
    <article itemscope itemtype="http://schema.org/WebPage" <?php post_class('hire-us'); ?>>

      <div class="post-header">
        <div class="post-top page hire-us">
          <?php include(locate_template('partials/sharing-link.php')); ?>
        </div>

        <h1 itemprop="headline"><?php the_title(); ?></h1>
        <hr>
      </div>

      <?php if (has_post_thumbnail()): ?>
        <?php
        $thumb_id  = get_post_thumbnail_id();
        $thumb_src = wp_get_attachment_image_src($thumb_id, 'full');
        ?>
        <div class="post-featured-image">
          <img src="<?php echo $thumb_src[0]; ?>" width="100%" alt="<?php the_title(); ?>" itemprop="thumbnailUrl">
        </div>
      <?php endif; ?>

      <div class="post-intro" itemprop="text">
        <div class="intro-inner">
          <?php the_content(); ?>
        </div>
      </div>

      <?php if (fwe_theme_option_exists('hire_us_form_id')): ?>
        <div id="hire-form" class="post-content">
          <?php
          $form   = GFAPI::get_form($fwe_settings['hire_us_form_id']);
          $fields = $form['fields'];
          ?>
          <form action="<?php echo site_url('/wp-json/fwe/hire-us'); ?>" method="post">
            <p>
              Hi, <label for="hire-name">my name is</label> <?php fwe_gform_input($fields[0], array('class' => 'madlib', 'id' => 'hire-name')); ?>, and <label for="hire-company">I work at</label> <?php fwe_gform_input($fields[1], array('id' => 'hire-company', 'class' => 'madlib')); ?>.
              <label for="hire-address">We're located at</label> <?php fwe_gform_input($fields[2], array('id' => 'hire-address', 'class' => 'madlib')); ?> <label for="hire-city">in</label> <?php fwe_gform_input($fields[3], array('id' => 'hire-city', 'class' => 'madlib')); ?>,
              <select id="hire-state" name="<?php echo esc_attr($fields[4]['id']); ?>" class="madlib">
                <?php foreach ($fields[4]['choices'] as $state): ?>
                  <option value="<?php echo esc_attr($state['value']); ?>">
                    <?php echo $state['text']; ?>
                  </option>
                <?php endforeach; ?>
              </select>.
                <label for="hire-email">My email address is</label> <?php fwe_gform_input($fields[5], array('type' => 'email', 'id' => 'hire-email', 'class' => 'madlib')); ?>, and <label for="hire-phone">my phone number is</label> <?php fwe_gform_input($fields[6], array('type' => 'tel', 'id' => 'hire-phone', 'class' => 'madlib')); ?>.
            </p>

            <p>
              <label for="hire-service">I'm really interested in talking about</label>
              <select id="hire-service" name="<?php echo esc_attr($fields[7]['id']); ?>" class="madlib">
                <?php foreach ($fields[7]['choices'] as $service): ?>
                  <option value="<?php echo esc_attr($service['value']); ?>">
                    <?php echo $service['text']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              for my company.
              <label for="hire-date">We have an event on</label> <?php fwe_gform_input($fields[8], array('type' => 'date', 'id' => 'hire-date', 'class' => 'madlib')); ?> that we think Fourth Wall Events would be perfect for.
              We thought that <label for="hire-location">the event could take place in</label> <?php fwe_gform_input($fields[10], array('id' => 'hire-location', 'class' => 'madlib')); ?>.
            </p>

            <p>
              <label for="hire-rfp">Here is my RFP:</label> <input type="file" id="hire-rfp" placeholder="Browse" name="rfp_file" class="madlib">.
            </p>

            <p>
              I look forward to hearing back from you soon. <label for="hire-contact">I'd prefer if you'd contact me via</label> <?php fwe_gform_input($fields[12], array('id' => 'hire-contact', 'class' => 'madlib')); ?>, and <label for="hire-time">the best time to reach me is usually</label>
              <select id="hire-time" name="<?php echo esc_attr($fields[13]['id']); ?>" class="madlib">
                <?php foreach ($fields[13]['choices'] as $time): ?>
                  <option value="<?php echo esc_attr($time['value']); ?>">
                    <?php echo $time['text']; ?>
                  </option>
                <?php endforeach; ?>
              </select>.
            </p>

            <p>
              Thanks,
              <br>
              <?php fwe_gform_input($fields[14], array('id' => 'hire-nickname', 'class' => 'madlib')); ?>
            </p>

            <input type="hidden" id="hire-rfp-file-data" name="rfp_file_data" value="">
            <input type="hidden" id="hire-rfp-file-mime-type" name="<?php echo esc_attr($fields[16]['id']); ?>" value="">
            <input type="hidden" id="hire-rfp-file-name" name="<?php echo esc_attr($fields[17]['id']); ?>" value="">

            <p class="right">
              <button id="hire-submit" type="submit">
                <label class="button-label">Submit &raquo;</label>
              </button>
            </p>
          </form>
        </div>
      <?php endif; ?>

    </article>
  </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
