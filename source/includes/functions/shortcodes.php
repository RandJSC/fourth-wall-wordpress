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
function fwe_testimonial_slider($atts) {
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
        <a class="slider-dot" href="" data-index="<?php echo $i; ?>"></a>
      <?php endfor; ?>
    </div>
  </div>
<?php
  return ob_get_clean();
}
add_shortcode('testimonial_slider', 'fwe_testimonial_slider');

?>
