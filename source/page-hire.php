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
          <p>
            Hi, <label for="hire-name">my name is</label> <input type="text" class="madlib" id="hire-name" placeholder="<?php echo esc_attr($fields[0]['description']); ?>" name="0">, and <label for="hire-company">I work at</label> <input type="text" class="madlib" id="hire-company" placeholder="<?php echo esc_attr($fields[1]['description']); ?>" name="1">.
            <label for="hire-address">We're located at</label> <input type="text" class="madlib" id="hire-address" placeholder="<?php echo esc_attr($fields[2]['description']); ?>" name="2"> <label for="hire-city">in</label> <input type="text" class="madlib" id="hire-city" placeholder="<?php echo esc_attr($fields[3]['description']); ?>" name="3">,
            <select id="hire-state" name="4" class="madlib">
              <?php foreach ($fields[4]['choices'] as $state): ?>
                <option value="<?php echo esc_attr($state['value']); ?>">
                  <?php echo $state['text']; ?>
                </option>
              <?php endforeach; ?>
            </select>.
            <label for="hire-email">My email address is</label> <input type="email" id="hire-email" class="madlib" placeholder="<?php echo esc_attr($fields[5]['description']); ?>" name="5">, and <label for="hire-phone">my phone number is</label> <input type="phone" id="hire-phone" class="madlib" placeholder="<?php echo esc_attr($fields[6]['description']); ?>" name="6">.
          </p>

          <p>
            <label for="hire-service">I'm really interested in talking about</label>
            <select id="hire-service" name="7" class="madlib">
              <?php foreach ($fields[7]['choices'] as $service): ?>
                <option value="<?php echo esc_attr($service['value']); ?>">
                  <?php echo $service['text']; ?>
                </option>
              <?php endforeach; ?>
            </select>
            for my company.
            <label for="hire-date">We have an event on</label> <input type="date" id="hire-date" class="madlib" name="8"> that we think Fourth Wall Events would be perfect for.
            <label for="hire-budget">We've got a budget range of</label> <input type="text" id="hire-budget" class="madlib" placeholder="<?php echo esc_attr($fields[9]['description']); ?>" name="9">
            and are looking for some great ideas.
            We thought that <label for="hire-location">the event could take place in</label> <input type="text" id="hire-location" class="madlib" placeholder="<?php echo esc_attr($fields[10]['description']); ?>" name="10">.
          </p>

          <p>
            <label for="hire-rfp">I have an RFP that you can fill out</label> <input type="file" id="hire-rfp" placeholder="Browse" name="11" class="madlib">.
          </p>

          <p>
            I look forward to hearing back from you soon. <label for="hire-contact">I'd prefer if you'd contact me via</label> <input type="text" id="hire-contact" class="madlib" placeholder="<?php echo esc_attr($fields[12]['description']); ?>" name="12">, and <label for="hire-time">the best time to reach me is usually</label> <input type="text" id="hire-time" class="madlib" placeholder="<?php echo esc_attr($fields[13]['description']); ?>" name="13">
            <select id="hire-am-pm" name="14">
              <?php foreach ($fields[14]['choices'] as $time): ?>
                <option value="<?php echo $time['value']; ?>">
                  <?php echo $time['text']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </p>
        </div>
      <?php endif; ?>

    </article>
  </section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
