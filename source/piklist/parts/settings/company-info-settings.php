<?php
/*
Title: Company Information
Setting: fwe_settings
Tab: Company Info
*/

piklist('field', array(
  'type'  => 'text',
  'field' => 'company_name',
  'label' => 'Company Name',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'description',
  'label' => 'Short Description',
));

piklist('field', array(
));

piklist('field', array(
));

piklist('field', array(
));

piklist('field', array(
));

piklist('field', array(
));

piklist('field', array(
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'google_maps_link',
  'label' => 'Google Maps Link',
  'value' => 'https://www.google.com/maps/place/Fourth+Wall+Events/@40.755227,-73.988349,15z/data=!4m2!3m1!1s0x0:0x9051d405614e4d61',
));

piklist('field', array(
  'type'     => 'group',
  'field'    => 'locations',
  'label'    => 'Locations',
  'add_more' => true,
  'fields'   => array(
    array(
      'type'    => 'text',
      'field'   => 'location_name',
      'label'   => 'Location Name',
      'columns' => 12,
    ),
    array(
      'type'        => 'text',
      'field'       => 'address',
      'label'       => 'Street Address',
      'description' => 'Include second line (suite number, etc.)',
      'columns'     => 12,
    ),
    array(
      'type'    => 'text',
      'field'   => 'city',
      'label'   => 'City',
      'columns' => 7,
    ),
    array(
      'type'    => 'text',
      'field'   => 'state',
      'label'   => 'State',
      'columns' => 5,
    ),
    array(
      'type'    => 'text',
      'field'   => 'zip_code',
      'label'   => 'Zip Code',
      'columns' => 3,
    ),
    array(
      'type'    => 'text',
      'field'   => 'phone',
      'label'   => 'Phone Number',
      'columns' => 9,
    ),
    array(
      'type'    => 'text',
      'field'   => 'contact_email',
      'label'   => 'Contact Email',
      'columns' => 12,
    ),
  ),
))
?>
