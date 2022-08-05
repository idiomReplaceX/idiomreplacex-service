<?php

class TestFilterMethod implements IFilterMethod {

  private $tokenizer;
  private $markEveryNthWord = 2;

  /**
   * @param null $text
   */
  public function __construct($text) {
    $this->tokenizer  = new HtmlReplacementTokenizer($text);
  }

  /**
   * @return null
   */
  public function getText() {
    return $this->tokenizer->text;
  }

  /**
   * @return array
   */
  public function getReplaceTokens(): array {
    return $this->tokenizer->rpTokens;
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