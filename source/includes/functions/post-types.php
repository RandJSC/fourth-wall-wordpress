<?php
/**
 * Fourth Wall Events
 * Custom Post Type Registration
 */

/**
 * Post Type: team_member
 */
function fwe_register_post_type_team_member($post_types) {

  $labels         = piklist('post_type_labels', 'Team Members');
  $labels['name'] = 'Team Members';

  $post_types['team_member'] = array(
    'labels'    => $labels,
    'title'     => 'Enter a title...',
    'public'    => true,
    'menu_icon' => 'dashicons-admin-users',
    'rewrite'   => array(
      'slug' => 'team',
    ),
    'supports'  => array(
      'title',
      'editor',
      'revisions',
      'thumbnail',
      'excerpt',
    ),
    'hide_meta_box' => array(
      'author',
      'comments',
      'commentstatus',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_team_member');

/**
 * Post Type: call_to_action
 */
function fwe_register_post_type_call_to_action($post_types) {

  $post_types['call_to_action'] = array(
    'labels' => array(
      'name'               => 'Calls to Action',
      'singular_name'      => 'Call to Action',
      'menu_name'          => 'CTAs',
      'add_new_item'       => 'Add New Call to Action',
      'edit_item'          => 'Edit Call to Action',
      'new_item'           => 'New Call to Action',
      'view_item'          => 'View Call to Action',
      'search_items'       => 'Search Calls to Action',
      'not_found'          => 'No calls to action found',
      'not_found_in_trash' => 'No calls to action found in Trash',
      'parent_item_colon'  => 'Parent CTA',
    ),
    'title'     => 'Enter a title...',
    'public'    => true,
    'menu_icon' => 'dashicons-megaphone',
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
    'show_in_nav_menus'   => false,
    'rewrite'   => array(
      'slug' => 'cta',
    ),
    'supports' => array(
      'title',
      'author',
      'editor',
    ),
    'hide_meta_box' => array(
      'slug',
      'author',
      'comments',
      'commentstatus',
      'revisions',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_call_to_action');

/**
 * Post Type: gallery
 */
function fwe_register_post_type_gallery($post_types) {

  $labels         = piklist('post_type_labels', 'Galleries');
  $labels['name'] = 'Galleries';

  $post_types['gallery'] = array(
    'labels'      => $labels,
    'title'       => 'Enter a title...',
    'public'      => true,
    'menu_icon'   => 'dashicons-format-gallery',
    'has_archive' => true,
    'rewrite'     => array(
      'slug' => 'gallery',
    ),
    'supports'    => array(
      'title',
      'editor',
      'thumbnail',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_gallery');

/**
 * Post Type: case_study
 */
function fwe_register_post_type_case_study($post_types) {

  $labels         = piklist('post_type_labels', 'Case Studies');
  $labels['name'] = 'Case Studies';

  $post_types['case_study'] = array(
    'labels'      => $labels,
    'title'       => 'Enter a title...',
    'public'      => true,
    'menu_icon'   => 'dashicons-awards',
    'has_archive' => true,
    'rewrite'     => array(
      'slug' => 'case-study',
    ),
    'supports'    => array(
      'title',
      'editor',
      'revisions',
      'thumbnail',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_case_study');

/**
 * Post Type: testimonial
 */
function fwe_register_post_type_testimonial($post_types) {

  $labels         = piklist('post_type_labels', 'Testimonials');
  $labels['name'] = 'Testimonials';

  $post_types['testimonial'] = array(
    'labels'              => $labels,
    'title'               => 'Enter a Title...',
    'public'              => true,
    'menu_icon'           => 'dashicons-testimonial',
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
    'show_in_nav_menus'   => false,
    'rewrite'             => array( 'slug' => 'testimonial' ),
    'supports'            => array(
      'title',
      'editor',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_testimonial');

/**
 * Post Type: accordion
 */
function fwe_register_post_type_accordion($post_types) {

  $labels         = piklist('post_type_labels', 'Accordions');
  $labels['name'] = 'Accordions';

  $post_types['accordion'] = array(
    'labels'              => $labels,
    'title'               => 'Enter a Title...',
    'public'              => true,
    'menu_icon'           => 'dashicons-editor-justify',
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
    'show_in_nav_menus'   => false,
    'rewrite'             => array( 'slug' => 'accordion' ),
    'supports'            => array(
      'title',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_accordion');

/**
 * Post Type: location
 */
function fwe_register_post_type_location($post_types) {

  $labels         = piklist('post_type_labels', 'Locations');
  $labels['name'] = 'Locations';

  $post_types['location'] = array(
    'labels'              => $labels,
    'title'               => 'Enter Location Name...',
    'public'              => true,
    'menu_icon'           => 'dashicons-location-alt',
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'show_in_nav_menus'   => false,
    'rewrite'             => array( 'slug' => 'location' ),
    'supports'            => array(
      'title',
      'thumbnail',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_location');

?>
