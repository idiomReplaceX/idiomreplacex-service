<?php

namespace classes\tokenizer;

class ReplaceToken {

  private $replacement = NULL;

  private $textToken;

  /**
   * @param $textToken
   * @param \classes\tokenizer\TextToken $replacement
   */
  public function __construct($textToken, TextToken $replacement) {
    $this->textToken = $textToken;
    $this->replacement = $replacement;
  }

  /**
   * @return TextToken
   */
  public function getToken(): ?TextToken {
    return $this->textToken->getToken();
  }


  /**
   * @return int
   */
  public function getStart(): int {
    return $this->textToken->getStart();
  }

  /**
   * @return string
   */
  public function getReplacement(): ?string {
    return $this->replacement;
  }

  /**
   * @param string $replacement
   */
  public function setReplacement(string $replacement): void {
    $this->replacement = $replacement;
  }





}