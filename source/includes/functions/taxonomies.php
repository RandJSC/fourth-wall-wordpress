<?php
/**
 * Fourth Wall Events
 * Custom Taxonomy Regstration
 */

function fwe_register_taxonomy_event_category($taxonomies) {
  $taxonomies[] = array(
    'post_type'         => array('gallery', 'case_study'),
    'name'              => 'event_category',
    'show_admin_column' => true,
    'configuration'     => array(
      'hierarchical' => true,
      'labels'       => piklist('taxonomy_labels', 'Event Category'),
      'show_ui'      => true,
      'query_var'    => true,
      'rewrite'      => array(
        'slug' => 'event-category',
      )
    ),
  );

  return $taxonomies;
}
add_filter('piklist_taxonomies', 'fwe_register_taxonomy_event_category');

?>
