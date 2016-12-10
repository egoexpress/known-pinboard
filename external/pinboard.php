<?php

class PinboardException extends Exception {}

class Pinboard {
  protected $apiKey;
  protected $apiUrl = 'https://api.pinboard.in/v1/';

  public function __construct($apiKey) {
    if (!function_exists("curl_init")){
      throw new PinboardException('Please install cUrl for PHP', 501);
    }

    if (empty($apiKey)) {
      throw new PinboardException('Please provide complete details for class initialization', 500);
    }
    $this->apiKey = $apiKey;
  }

  public function createBookmark($url, $description, array $optionalData) {
    $this->paramsValidate($url, $description);
    $requestArray = array('url' => $url, 'description' => $description,);

    $bookmarkSaveParameters = array('extended', 'tags');

    foreach ($optionalData as $key => $option) {
      if (in_array($key, $bookmarkSaveParameters)) {
        if ($key === 'tags') {
          $temp= implode(',', explode(',', $option));
          if (!empty($temp)) {
            $requestArray[$key]= $option;
          }
        } else {
          $requestArray[$key]= $option;
        }
        $requestArray[$key]= substr($requestArray[$key], 0, 250);
      }
    }
    return $this->httpRequest($this->apiUrl . 'posts/add' . '?auth_token=' . $this->apiKey, $requestArray);
  }

  protected function paramsValidate($url, $title) {
    if ((strlen($url) < 2) || (strlen($title) < 2)) {
      throw new PinboardException('Title or URL is too short', 500);
    }
    return true;
  }

  protected function httpRequest($url, $params = null, $request = 'GET') {
    // URL-encode parameters and add to request URL
    $urlParams = $this->preparePostFields($params);
    $fullURL = $url . '&' . $urlParams;
    $ch = curl_init($fullURL);

    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatusCode !== 200) {
      if ((empty($data) || (!is_string($data)))) {
        $data = 'Unknown Pinboard network API error';
      }
      throw new PinboardException($data, $httpStatusCode);
    }
    return $data;
  }

  protected function preparePostFields($array) {
    $params = array();
    foreach ($array as $key => $value) {
      $ret = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
      $params[] = urlencode($key) . '=' . urlencode($ret);
    }
    return implode('&', $params);
  }
}
