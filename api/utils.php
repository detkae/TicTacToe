<?php

function generateRandomString($length) {
    $include_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charLength = strlen($include_chars);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $include_chars [rand(0, $charLength - 1)];
    }
    return $randomString;
}

function returnUnauthorized($message = "") {
  http_response_code (401);
  $response->errer_message = $message;
  echo json_encode($response);
  exit;
}

function nullOrValue($value) {
  if (empty($value)) {
    return NULL;
  } else {
    return $value;
  }
}

?>