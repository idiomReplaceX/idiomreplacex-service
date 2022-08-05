<?php

namespace classes\tokenizer;

class TextToken {

  private $start = -1;

  private $token = NULL;

  /**
   * @param int $start
   * @param null $token
   */
  public function __construct(int $start, $token) {
    $this->start = $start;
    $this->token = $token;
  }

  /**
   * @return int
   */
  public function getStart(): int {
    return $this->start;
  }

  /**
   * @param int $start
   */
  public function setStart(int $start): void {
    $this->start = $start;
  }

  /**
   * @return null
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * @param null $token
   */
  public function setToken($token): void {
    $this->token = $token;
  }




}