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
  'type'        => 'text',
  'field'       => 'address',
  'label'       => 'Street Address',
  'description' => 'Include second line (suite number, etc.)'
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'city',
  'label' => 'City',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'state',
  'label' => 'State',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'zip_code',
  'label' => 'Zip Code',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'phone',
  'label' => 'Phone Number',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'contact_email',
  'label' => 'Contact Email',
));

piklist('field', array(
  'type'  => 'text',
  'field' => 'google_maps_link',
  'label' => 'Google Maps Link',
  'value' => 'https://www.google.com/maps/place/Fourth+Wall+Events/@40.755227,-73.988349,15z/data=!4m2!3m1!1s0x0:0x9051d405614e4d61',
));
?>
