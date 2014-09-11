<?php
/**
 * Fourth Wall Events
 * Shortcodes
 */

function fwe_intro_paragraph_shortcode($atts, $content = null) {
  extract(shortcode_atts(array(
    'class' => '',
    'id'    => '',
  ), $atts));

  $class_names = array('intro');

  if (!empty($class)) {
    $extra_classes = explode(' ', $class);
    $class_names = array_merge($class_names, $extra_classes);
  }

  $class_names = implode(' ', $class_names);
  $class_names = ' class="' . $class_names . '"';

  $id = !empty($id) ? ' id="' . $id . '"' : '';

  ob_start();
?>
  <div<?php echo $class_names . $id; ?>>
    <?php echo $content; ?>
  </div>
<?php
}
add_shortcode('intro', 'fwe_intro_paragraph_shortcode');
?>
