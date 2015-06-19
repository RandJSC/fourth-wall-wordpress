<?php
/**
 * Fourth Wall Events
 * Hire Us Form API
 */

class FourthWall_HireUs {

  protected $allowed_mime_types = array(
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/msword',
    'application/pdf',
    'application/vnd.oasis.opendocument.text',
    'text/plain',
    'text/richtext',
  );

  protected $required_fields = array(
    2, // Name
    3, // Company
    4, // Address
    5, // City
    6, // State
    7, // Email
    16, // Phone
    8, // Service
    9, // Event Date
    //10, // Budget
    11, // Location
    13, // Contact Method
    //14, // Contact Time
    18, // Nickname
  );

  public function register_routes( $routes ) {
    $routes['/fwe/hire-us'] = array(
      array( array($this, 'create_submission'), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
    );

    return $routes;
  }

  public function create_submission( $data = null ) {

    $settings    = get_option('fwe_settings');
    $form_id     = $settings['hire_us_form_id'];
    $upload_dir  = WP_CONTENT_DIR . '/rfp-uploads';
    $success_msg = array_key_exists('hire_us_success_message', $settings) ? $settings['hire_us_success_message'] : 'Thank you!';
    $mime_type   = $data[19];

    if ($mime_type && !in_array($mime_type, $this->allowed_mime_types)) {
      return new WP_Error('That file type is not allowed.');
    }

    $invalid_fields = $this->validate_submission($data);

    if (!empty($invalid_fields)) {
      return new WP_Error('The following required fields were invalid: ' . implode(', ', $invalid_fields));
    }

    // Make the uploads folder if it doesn't exist
    if (!is_dir($upload_dir)) {
      $mkdir_success = wp_mkdir_p($upload_dir);

      if (!$mkdir_success) {
        return new WP_Error('Could not create upload directory.');
      }
    }

    // Save the RFP file data as a file on the server
    if (!empty($data['rfp_file_data'])) {
      $filename    = wp_unique_filename($upload_dir, $data[20]);
      $file_data   = $this->get_binary_data($data['rfp_file_data']);
      $upload_path = trailingslashit($upload_dir) . $filename;
      $file_url    = content_url('/rfp-uploads/' . $filename);

      if (!file_put_contents($upload_path, $file_data)) {
        return new WP_Error('Error saving RFP file.');
      }

      // Don't store base64 garbage in the database
      unset($data['rfp_file_data']);
    }

    // Store the form responses in Gravity Forms
    $data['form_id']      = $form_id;
    $data['date_created'] = strftime('%Y-%m-%d %H:%M');
    $data[21]             = $file_url;

    $entry_id = GFAPI::add_entry($data);

    // Give the user back a sanitized version of their input for displaying on the Thank You message
    $response_data = array_merge($data, array(
      'status'   => 'OK',
      'entry_id' => $entry_id,
      'message'  => $success_msg,
    ));
    unset($response_data[21]);

    $response = new WP_JSON_Response();
    $response->set_data($response_data);

    return $response;
  }

  private function validate_submission($data) {
    $invalid_fields  = array();

    foreach ($this->required_fields as $field) {
      if (!array_key_exists($field, $data) || empty($data[$field])) {
        $invalid_fields[] = $field;
      }
    }

    return $invalid_fields;
  }

  private function log($value, $file = '/home/vagrant/wp-api.log') {
    ob_start();
    print_r($value);
    echo "\n";
    $data = ob_get_clean();

    file_put_contents($file, $data, FILE_APPEND);
  }

  private function get_binary_data($data_uri) {
    $data = str_replace(' ', '+', $data_uri);
    $data = substr($data, 5);  // remove "data:" prefix
    $data = 'data://' . $data; // replace with "data://" prefix

    return file_get_contents($data);
  }

}

?>
