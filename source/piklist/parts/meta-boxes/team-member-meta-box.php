<?php
/*
Title: Team Member Details
Post Type: team_member
Context: normal
Priority: high
*/

piklist('field', array(
  'type'       => 'text',
  'field'      => 'given_name',
  'label'      => 'Given (First) Name',
  'help'       => 'If you leave this blank, we\'ll try to guess it from the team member\'s full name.',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'surname',
  'label'      => 'Surname',
  'help'       => 'If you leave this blank, we\'ll try to guess it from the team member\'s full name.',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'job_title',
  'label'      => 'Job Title',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'location',
  'label'      => 'Location',
  'attributes' => array(
    'class' => 'text',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'email_address',
  'label'      => 'Email Address',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate'   => array(
    'type' => 'email',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'facebook',
  'label'      => 'Facebook',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate' => array(
    'type' => 'url',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'twitter',
  'label'      => 'Twitter',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate' => array(
    'type' => 'url',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'instagram',
  'label'      => 'Instagram',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate' => array(
    'type' => 'url',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'linkedin',
  'label'      => 'LinkedIn',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate' => array(
    'type' => 'url',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'pinterest',
  'label'      => 'Pinterest',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate' => array(
    'type' => 'url',
  ),
));

piklist('field', array(
  'type'       => 'text',
  'field'      => 'google_plus',
  'label'      => 'Google+',
  'attributes' => array(
    'class' => 'text',
  ),
  'validate' => array(
    'type' => 'url',
  ),
));

?>
