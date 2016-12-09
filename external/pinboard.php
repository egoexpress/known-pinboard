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

