<?php

class ReplaceToken {

  public $start = -1;
  public $token = null;
  public $replacement = null;

  /**
   * @param int $start
   * @param null $token
   * @param null $replacement
   */
  public function __construct(int $start, $token, $replacement) {
    $this->start = $start;
    $this->token = $token;
    $this->replacement = $replacement;
  }

}