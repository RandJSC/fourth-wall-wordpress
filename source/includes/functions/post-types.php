<?php
/**
 * Fourth Wall Events
 * Custom Post Type Registration
 */

/**
 * Post Type: team_member
 */
function fwe_register_post_type_team_member($post_types) {

  $post_types['team_member'] = array(
    'labels'    => piklist('post_type_labels', 'Team Member'),
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

  $post_types['gallery'] = array(
    'labels'    => piklist('post_type_labels', 'Gallery'),
    'title'     => 'Enter a title...',
    'public'    => true,
    'menu_icon' => 'dashicons-format-gallery',
    'rewrite'   => array(
      'slug' => 'gallery',
    ),
    'supports'  => array(
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

  $post_types['case_study'] = array(
    'labels'    => piklist('post_type_labels', 'Case Study'),
    'title'     => 'Enter a title...',
    'public'    => true,
    'menu_icon' => 'dashicons-awards',
    'rewrite'   => array(
      'slug' => 'case-study',
    ),
    'supports'  => array(
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

  $post_types['testimonial'] = array(
    'labels'    => piklist('post_type_labels', 'Testimonial'),
    'title'     => 'Enter a Title...',
    'public'    => true,
    'menu_icon' => 'dashicons-testimonial',
    'rewrite'   => array( 'slug' => 'testimonial' ),
    'supports'  => array(
      'title',
      'editor',
    ),
  );

  return $post_types;
}
add_filter('piklist_post_types', 'fwe_register_post_type_testimonial');

?>
