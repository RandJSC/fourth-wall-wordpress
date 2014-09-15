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
?>
