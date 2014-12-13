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

  public function register_routes( $routes ) {
    $routes['/fwe/hire-us'] = array(
      array( array($this, 'create_submission'), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
    );

    return $routes;
  }

  public function create_submission( $data = null ) {

    $settings   = get_option('fwe_settings');
    $form_id    = $settings['hire_us_form_id'];
    $upload_dir = WP_CONTENT_DIR . '/rfp-uploads';

    // Make the uploads folder if it doesn't exist
    if (!is_dir($upload_dir)) {
      $mkdir_success = wp_mkdir_p($upload_dir);

      if (!$mkdir_success) {
        return new WP_Error('Could not create upload directory.');
      }
    }

    // Save the RFP file data as a file on the server
    $filename    = wp_unique_filename($upload_dir, $data[20]);
    $file_data   = $this->get_binary_data($data['rfp_file_data']);
    $upload_path = trailingslashit($upload_dir) . $filename;
    $file_url    = content_url('/rfp-uploads/' . $filename);

    if (!file_put_contents($upload_path, $file_data)) {
      return new WP_Error('Error saving RFP file.');
    }

    // Don't store base64 garbage in the database
    unset($data['rfp_file_data']);

    // Store the form responses in Gravity Forms
    $data['form_id']      = $form_id;
    $data['date_created'] = strftime('%Y-%m-%d %H:%M');
    $data[21]             = $file_url;

    $entry_id = GFAPI::add_entry($data);

    // Give the user back a sanitized version of their input for displaying on the Thank You message
    $response_data = array_merge($data, array('status' => 'OK', 'entry_id' => $entry_id));
    unset($response_data[21]);

    $response = new WP_JSON_Response();
    $response->set_data($response_data);

    return $response;
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
