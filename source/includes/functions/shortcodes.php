<?php
/**
 * Fourth Wall Events
 * Shortcodes
 */

/**
 * Intro Paragraph for Pages
 * ex. [intro class="foo" id="main-intro"]Hello World[/intro]
 */
function fwe_intro_paragraph_shortcode($atts, $content = null) {
  extract(shortcode_atts(array(
    'class' => '',
    'id'    => '',
  ), $atts));

  $class_names = array('intro');

  if (!empty($class)) {
    $extra_classes = explode(' ', $class);
    $class_names   = array_merge($class_names, $extra_classes);
  }

  $class_names = ' class="' . implode(' ', $class_names) . '"';

  $id = !empty($id) ? ' id="' . $id . '"' : '';

  ob_start();
?>
  <div<?php echo $class_names . $id; ?>>
    <?php echo $content; ?>
  </div>
<?php
}
add_shortcode('intro', 'fwe_intro_paragraph_shortcode');

/**
 * Testimonial Slider
 * ex. [testimonial_slider count="3" orderby="rand" /]
 */
function fwe_testimonial_slider_shortcode($atts) {
  extract(shortcode_atts(array(
    'count'   => 3,
    'orderby' => 'date',
    'order'   => 'DESC',
  ), $atts));

  $query_args  = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => (int) $count,
    'post_status'    => 'publish',
    'orderby'        => $orderby,
    'order'          => $order,
  );
  $query       = new WP_Query($query_args);
  $total_posts = $query->post_count;

  if (!$query->have_posts()) return '';

  ob_start();
?>
  <div class="testimonial-slider">
    <ul class="testimonials">
      <?php while ($query->have_posts()): $query->the_post(); ?>
        <?php
        $post_id      = get_the_ID();
        $author_name  = get_post_meta($post_id, 'author_name', true);
        $author_title = get_post_meta($post_id, 'author_position', true);
        ?>
        <li <?php post_class(); ?>>
          <div class="quote left">&ldquo;</div>
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
          <div class="quote right">&rdquo;</div>
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
<?php
  return ob_get_clean();
}
add_shortcode('testimonial_slider', 'fwe_testimonial_slider_shortcode');

/**
 * Accordion
 * ex. [accordion id="1" headers="h3" /]
 */
function fwe_accordion_shortcode($atts) {
  extract(shortcode_atts(array(
    'id'     => null,
    'header' => 'h3',
  ), $atts));

  $accordion = get_post($id);

  if (!$accordion || $accordion->post_type !== 'accordion') return '';

  $panes = get_post_meta($id, 'accordion_panes', true);

  if (!(
    count($panes) &&
    array_key_exists('content', $panes) &&
    count($panes['content'])
  )) {

    return '';
  }

  $pane_count = max(
    count($panes['content']),
    count($panes['title'])
  );

  ob_start();
?>
  <div class="accordion">
    <?php for ($i = 0; $i < $pane_count; $i++): ?>
      <?php
      if (empty($panes['content'][$i]) || empty($panes['title'][$i])) continue;

      $header_id    = 'accordion-' . $id . '-header-' . $i;
      $pane_id      = 'accordion-' . $id . '-pane-' . $i;
      $pane_icon    = wp_get_attachment_image_src($panes['icon'][$i][0], 'full');
      $header_style = fwe_style_attribute(array(
        'background-color' => $panes['header_background'][$i],
      ));
      ?>
      <div class="pane">
        <div class="pane-header" id="<?php echo $header_id; ?>"<?php echo $header_style; ?>>
          <?php echo '<' . $header . '>'; ?>
            <a href="#<?php echo $pane_id; ?>">
              <div class="icon">
                <img src="<?php echo $pane_icon[0]; ?>">
              </div>
              <div class="title"><?php echo apply_filters('the_title', $panes['title'][$i]); ?></div>
              <div class="plusminus">+</div>
            </a>
          <?php echo '</' . $header . '>'; ?>
        </div>

        <div class="pane-content" id="<?php echo $pane_id; ?>">
          <div class="pane-body">
            <?php echo apply_filters('the_content', $panes['content'][$i]); ?>
          </div>
        </div>
      </div>
    <?php endfor; ?>
  </div>
<?php
  return ob_get_clean();
}
add_shortcode('accordion', 'fwe_accordion_shortcode');

function fwe_team_members_shortcode($atts, $content = null) {
  extract(shortcode_atts(array(
    'order'    => 'ASC',
    'orderby'  => 'meta_value',
    'meta_key' => 'surname',
  ), $atts));

  $team_members = new WP_Query(array(
    'post_type'      => 'team_member',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => $orderby,
    'order'          => $order,
    'meta_key'       => $meta_key,
  ));

  ob_start();
  include(locate_template('partials/team-viewer.php'));
  return ob_get_clean();
}
add_shortcode('team_members', 'fwe_team_members_shortcode');
?>
