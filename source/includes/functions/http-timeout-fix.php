<?php
/**
 * Fourth Wall Events
 * Vagrant HTTP timeout fix
 */

$timeout = 15;

function fwe_request_args($request) {
  $request['timeout'] = $timeout;
  return $request;
}
add_action('http_request_args', 'fwe_request_args', 100, 1);

function fwe_api_curl($handle) {
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($handle, CURLOPT_TIMEOUT, $timeout);
}
add_action('http_api_curl', 'fwe_api_curl', 100, 1);
?>
