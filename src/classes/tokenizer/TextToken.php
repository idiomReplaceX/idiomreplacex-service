<?php

namespace classes\tokenizer;

class TextToken {

  private $start = -1;

  private $token = NULL;

  /**
   * @param int $start
   * @param string $token
   */
  public function __construct(int $start, string $token) {
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
   * @return string
   */
  public function getToken(): string {
    return $this->token;
  }

  /**
   * @return string
   *   Returns the token text decoded by html_entity_decode()
   */
  public function tokenDecoded(): string {
    return html_entity_decode($this->token);
  }

  /**
   * @param string $token
   */
  public function setToken(string $token): void {
    $this->token = $token;
  }




}