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

  <section id="main-page-content" class="content-section">
    <article itemscope itemtype="http://schema.org/WebPage" <?php post_class('hire-us'); ?>>

      <div class="post-header">
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

      <div class="post-content" itemprop="text">
        <?php the_content(); ?>
      </div>

      <?php if (array_key_exists('hire_us_form_id', $fwe_settings) && $fwe_settings['hire_us_form_id']): ?>
        <div id="hire-form" class="post-content">
          <?php
          $form   = GFAPI::get_form($fwe_settings['hire_us_form_id']);
          $fields = $form['fields'];
          ?>
          <form action="<?php echo site_url('/wp-json/fwe/hire-us'); ?>" method="post">
            <p>
              Hi, <label for="hire-name">my name is</label> <input type="text" class="madlib" id="hire-name" placeholder="<?php echo esc_attr($fields[0]['description']); ?>" name="<?php echo esc_attr($fields[0]['id']); ?>">, and <label for="hire-company">I work at</label> <input type="text" class="madlib" id="hire-company" placeholder="<?php echo esc_attr($fields[1]['description']); ?>" name="<?php echo esc_attr($fields[1]['id']); ?>">.
              <label for="hire-address">We're located at</label> <input type="text" class="madlib" id="hire-address" placeholder="<?php echo esc_attr($fields[2]['description']); ?>" name="<?php echo esc_attr($fields[2]['id']); ?>"> <label for="hire-city">in</label> <input type="text" class="madlib" id="hire-city" placeholder="<?php echo esc_attr($fields[3]['description']); ?>" name="<?php echo esc_attr($fields[3]['id']); ?>">,
              <select id="hire-state" name="<?php echo esc_attr($fields[4]['id']); ?>" class="madlib">
                <?php foreach ($fields[4]['choices'] as $state): ?>
                  <option value="<?php echo esc_attr($state['value']); ?>">
                    <?php echo $state['text']; ?>
                  </option>
                <?php endforeach; ?>
              </select>.
              <label for="hire-email">My email address is</label> <input type="email" id="hire-email" class="madlib" placeholder="<?php echo esc_attr($fields[5]['description']); ?>" name="<?php echo esc_attr($fields[5]['id']); ?>">, and <label for="hire-phone">my phone number is</label> <input type="tel" id="hire-phone" class="madlib" placeholder="<?php echo esc_attr($fields[6]['description']); ?>" name="<?php echo esc_attr($fields[6]['id']); ?>">.
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
              <label for="hire-date">We have an event on</label> <input type="date" id="hire-date" class="madlib" name="<?php echo esc_attr($fields[8]['id']); ?>"> that we think Fourth Wall Events would be perfect for.
              <label for="hire-budget">We've got a budget range of</label> <input type="text" id="hire-budget" class="madlib" placeholder="<?php echo esc_attr($fields[9]['description']); ?>" name="<?php echo esc_attr($fields[9]['id']); ?>">
              and are looking for some great ideas.
              We thought that <label for="hire-location">the event could take place in</label> <input type="text" id="hire-location" class="madlib" placeholder="<?php echo esc_attr($fields[10]['description']); ?>" name="<?php echo esc_attr($fields[10]['id']); ?>">.
            </p>

            <p>
              <label for="hire-rfp">I have an RFP that you can fill out</label> <input type="file" id="hire-rfp" placeholder="Browse" name="rfp_file" class="madlib">.
            </p>

            <p>
              I look forward to hearing back from you soon. <label for="hire-contact">I'd prefer if you'd contact me via</label> <input type="text" id="hire-contact" class="madlib" placeholder="<?php echo esc_attr($fields[12]['description']); ?>" name="<?php echo esc_attr($fields[12]['id']); ?>">, and <label for="hire-time">the best time to reach me is usually</label> <input type="time" id="hire-time" class="madlib" placeholder="<?php echo esc_attr($fields[13]['description']); ?>" name="<?php echo esc_attr($fields[13]['id']); ?>">.
            </p>

            <p>
              Thanks,
              <br>
              <input type="text" id="hire-nickname" name="<?php echo esc_attr($fields[14]['id']); ?>" placeholder="<?php echo esc_attr($fields[14]['description']); ?>" class="madlib">
            </p>

            <input type="hidden" id="hire-rfp-file-data" name="rfp_file_data" value="">
            <input type="hidden" id="hire-rfp-file-mime-type" name="<?php echo esc_attr($fields[16]['id']); ?>" value="">
            <input type="hidden" id="hire-rfp-file-name" name="<?php echo esc_attr($fields[17]['id']); ?>" value="">

            <p class="right">
              <button id="hire-submit" type="submit">Submit &raquo;</button>
            </p>
          </form>
          <?php var_dump($fields); ?>
        </div>
      <?php endif; ?>

    </article>
  </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
