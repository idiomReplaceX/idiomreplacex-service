<?php

namespace classes\tokenizer;

class ReplaceToken {

  private $replacement = NULL;

  private $textToken;

  /**
   * @param \classes\tokenizer\TextToken $textToken
   * @param string $replacement
   */
  public function __construct(TextToken $textToken, string $replacement) {
    $this->textToken = $textToken;
    $this->replacement = $replacement;
  }

  /**
   * @return string
   */
  public function getToken(): string {
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