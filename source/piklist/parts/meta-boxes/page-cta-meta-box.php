<?php
/*
Title: Call to Action
Post Type: page
Context: side
*/

$ctas = get_posts(array(
  'post_type'      => 'call_to_action',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'name',
  'order'          => 'ASC',
));
$choices = array('' => '-- Select a CTA --');

foreach ($ctas as $cta) {
  $choices[$cta->ID] = $cta->post_title;
}

piklist('field', array(
  'type'    => 'select',
  'field'   => 'call_to_action',
  'scope'   => 'post_meta',
  'label'   => 'Footer CTA',
  'choices' => $choices,
));
?>
