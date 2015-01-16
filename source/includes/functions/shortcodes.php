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

  include(locate_template('partials/testimonial-slider.php'));

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

  if (!$id) return '';

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

  include(locate_template('partials/accordion.php'));

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

function fwe_button_shortcode($atts, $content = null) {
  extract(shortcode_atts(array(
    'href' => '',
  ), $atts));

  ob_start();
?>
  <a href="<?php echo esc_url($href); ?>" class="button">
    <?php echo $content; ?>
  </a>
<?php
  return ob_get_clean();
}
add_shortcode('button', 'fwe_button_shortcode');
?>
