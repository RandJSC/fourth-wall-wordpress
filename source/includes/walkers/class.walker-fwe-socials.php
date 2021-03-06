<?php
/**
 * Fourth Wall Events
 * QuickLinks Nav Menu Walker
 *
 * Prints Font Awesome glyphs depending on the nav item's CSS classes
 */

class Walker_FWE_Socials extends Walker_Nav_Menu {
  
  public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $class_names = '';

    $classes = empty($item->classes) ? array() : (array)$item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    $filtered_classes = array_filter($classes, function($klass) {
      return !(strpos($klass, 'fa-') === 0);
    });

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($filtered_classes), $item, $args));
    $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = $id ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names . '>';

    $atts = array();
    $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
    $atts['title']  = !empty($atts['title']) ? $atts['title'] : apply_filters('the_title', $item->title, $item->ID);
    $atts['target'] = !empty($item->target) ? $item->target : '';
    $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
    $atts['href']   = !empty($item->url) ? $item->url : '';
    $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

    $attributes = '';
    foreach ($atts as $attr => $value) {
      if (!empty($value)) {
        $value = ('href' == $attr) ? esc_url($value) : esc_attr($value);
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    // Just take the first icon class we find, since buttons can't have 2 icons anyway
    $icon_classes = array_filter($classes, function($klass) {
      return strpos($klass, 'fa-') === 0;
    });
    $icon_class   = !empty($icon_classes) ? $icon_classes[0] : '';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';

    if ($icon_class) {
      $item_output .= '<span class="fa ' . $icon_class . '"></span>';
    }

    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }

}

?>
