<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;


class KackspechtFilterMethod implements IFilterMethod {

  private $tokenizer;
  private $rpTokens = null;
  private $markEveryNthWord = 2;

  /**
   * @param null $text
   */
  public function __construct($text) {
    $this->tokenizer  = new \tokenizer\HtmlTextTokenizer($text);
  }

  /**
   * @return null
   */
  public function getText() {
    return $this->tokenizer->getText();
  }

  /**
   * @return array
   */
  public function getReplaceTokens(): array {
    if($this->rpTokens === null){
      $this->makeReplacementTokens();
    }
    return $this->rpTokens;
  }

  /**
   * @return void
   */
  protected function makeReplacementTokens() {
    $wordTokenCount = 0;
    foreach($this->tokenizer->getTextTokens() as $textToken){
      $wordTokenCount++;
      if($wordTokenCount % $this->markEveryNthWord == 0){
        $newRPToken = new ReplaceToken($textToken, $this->replaceTokenText($textToken->getToken()));
        $this->rpTokens[] = $newRPToken;
      }
    }
  }


  /**
   * @param $tokenText
   *
   * @return string
   */
  protected static function replaceTokenText($tokenText): string {
        //return '<span style="color: purple">' . $tokenText . '</span>';
    return '<span style="color: red">' . "Kackspecht" . '</span>';
  }

}