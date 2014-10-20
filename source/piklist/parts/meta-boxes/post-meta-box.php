<?php
/*
Title: Post Customizations
Post Type: post
Context: normal
Priority: high
*/

$team_members = get_posts(array(
  'post_type'      => 'team_member',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'name',
  'order'          => 'ASC',
));
$team_member_choices = array('' => '-- Select a Team Member --');

foreach ($team_members as $person) {
  $team_member_choices[$person->ID] = $person->post_title;
}

piklist('field', array(
  'type'        => 'select',
  'field'       => 'team_member_id',
  'label'       => 'Team Member',
  'description' => 'The post will be attributed to the selected team member.',
  'choices'     => $team_member_choices,
));
?>
