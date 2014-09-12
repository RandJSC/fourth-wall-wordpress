<?php
/*
Title: Call to Action
Post Type: page
Context: side
*/

$cta_params = array(
  'post_type'      => 'call_to_action',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'name',
  'order'          => 'ASC',
);
$cta_query = new WP_Query($cta_params);

$choices = array('' => '-- Select a CTA --');

while ($cta_query->have_posts()) {
  $cta_query->the_post();
  $choices[get_the_ID()] = get_the_title();
}
wp_reset_postdata();

piklist('field', array(
  'type'    => 'select',
  'field'   => 'call_to_action',
  'scope'   => 'post_meta',
  'label'   => 'Footer CTA',
  'choices' => $choices,
));
?>
