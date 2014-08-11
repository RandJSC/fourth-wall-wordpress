<?php
/**
 * Fourth Wall Events
 * Vagrant HTTP timeout fix
 */

function fwe_request_args($request) {
  $request['timeout'] = 15;
  return $request;
}
add_action('http_request_args', 'fwe_request_args', 100, 1);

function fwe_api_curl($handle) {
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($handle, CURLOPT_TIMEOUT, 15);
}
add_action('http_api_curl', 'fwe_api_curl', 100, 1);
?>
