<?php

class ResponseData {
  public $replaceTokens = [];
  public $htmlChecksum = null;
  public $method = null;

  /**
   * @param array $replaceTokens
   * @param string $htmlChecksum
   * @param string $method
   */
  public function __construct(array $replaceTokens, $htmlChecksum, $method) {
    $this->replaceTokens = $replaceTokens;
    $this->htmlChecksum = $htmlChecksum;
    $this->method = $method;
  }

}