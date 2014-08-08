<?php
/**
 * Fourth Wall Events
 * Custom Post Type Registration
 */

add_filter('piklist_post_types', 'fwe_register_post_types');
function fwe_register_post_types($post_types) {

  $post_types['location'] = array(
    'labels' => piklist('post_type_labels', 'Location'),
    'title' => 'Enter a title...',
    'public' => true,
    'rewrite' => array(
      'slug' => 'location',
    ),
    'supports' => array(
      'title',
    ),
    'hide_meta_box' => array(
      'slug',
      'author',
      'comments',
      'commentstatus',
      'revisions',
    ),
  );

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
    'title' => 'Enter a title...',
    'public' => true,
    'rewrite' => array(
      'slug' => 'cta',
    ),
    'supports' => array(
      'title',
      'editor',
      'author',
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

?>
