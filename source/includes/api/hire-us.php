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
    $upload_dir = WP_CONTENT_DIR . '/rfp-uploads';

    if (!is_dir($upload_dir)) {
      $mkdir_success = wp_mkdir_p($upload_dir);

      if (!$mkdir_success) {
        return new WP_Error('Could not create upload directory.');
      }
    }

    $filename    = wp_unique_filename($upload_dir, $data[20]);
    $file_data   = $this->get_binary_data($data[17]);
    $upload_path = trailingslashit($upload_dir) . $filename;

    if (!file_put_contents($upload_path, $file_data)) {
      return new WP_Error('Error saving RFP file.');
    }

    $response = new WP_JSON_Response();

    $response->set_data(array('status' => 'OK', 'message' => 'Submission successful!'));

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
    $data = substr($data, 5); // remove "data:" prefix
    $data = 'data://' . $data; // replace with "data://" prefix

    return file_get_contents($data);
  }

}

?>
