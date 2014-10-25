<?php
/*
Title: Page Stitching
Post Type: page
Context: normal
Priority: high
*/

global $post;

$pages_args = array(
  'sort_column' => 'post_date',
  'sort_order'  => 'desc',
  'hierarchical' => 0,
);

if (property_exists($post, 'ID') && $post->ID) {
  $pages_args['exclude'] = array($post->ID);
}

$pages     = get_pages($pages_args);
$page_opts = array('' => '-- Select a Page --');

foreach ($pages as $idx => $page) {
  $page_opts[$page->ID] = $page->post_title;
}

piklist('field', array(
  'type'        => 'select',
  'scope'       => 'post_meta',
  'field'       => 'stitch_children',
  'label'       => 'Pages to Display',
  'description' => 'The selected pages will be shown below this page\'s content on the site. Drag and drop to change the order.',
  'attributes'  => array('class' => 'text'),
  'choices'     => $page_opts,
  'add_more'    => true,
));
?>
