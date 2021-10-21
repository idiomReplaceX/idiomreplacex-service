<?php

class TestFilterMethod implements IFilterMethod {

  private $text =  null;
  private $rpTokens = [];

  private $wordTokenCount = 0;
  private $markEveryNthWord = 2;

  private static $HTML_EL_START = '<';
  private static $HTML_EL_END = '>';
  /**
   * @param null $text
   */
  public function __construct($text) {
    $this->text = $text;
    $this->replacementTokens();
  }

  /**
   * @return null
   */
  public function getText() {
    return $this->text;
  }

  /**
   * @return array
   */
  public function getReplaceTokens(): array {
    return $this->rpTokens;
  }


  /**
   * Walks the text and creates the list of ReplaceToken
   */
  protected function replacementTokens() {

    $isHtmlElement = false;
    $tokenStartPos = 0;

    $len = strlen($this->text);
    for ($i = 0; $i < $len; $i++){
      $char = $this->text[$i];
      if(TestFilterMethod::$HTML_EL_END == $char && $isHtmlElement){
        // reaching end of HTML element
        $isHtmlElement = false;
        $tokenStartPos = $i + 1;
      } else if(TestFilterMethod::$HTML_EL_START == $char){
        // start of HTML element
        $isHtmlElement = true;
        $this->makeReplacementToken($tokenStartPos, $i);
      } else if(!$isHtmlElement && $this->isWordBoundary($char) ){
        $this->makeReplacementToken($tokenStartPos, $i);
        $tokenStartPos = $i + 1;
      }
    }
  }

  protected function isWordBoundary($char): bool {
      return preg_match("/[[:space:]]/", $char);
      // return array_search($char, TestFilterMethod::$WHITESPACE_CHARS) !== false;
  }

  /**
   * @param int $tokenStartPos
   * @param int $i
   *
   * @return boolean
   *  TRUE if a new token has been created and added to the rpTokens list, otherwise FALSE
   */
  protected function makeReplacementToken(int $tokenStartPos, int $i): bool {
    if ($tokenStartPos > -1 && $tokenStartPos < $i) {
      $tokenText = substr($this->text, $tokenStartPos, $i - $tokenStartPos);
      if(preg_match("/[[:alnum:]]/", $tokenText)){
        $this->wordTokenCount++;
        if($this->wordTokenCount % $this->markEveryNthWord == 0){
          $newRPToken = new ReplaceToken($tokenStartPos, $tokenText, $this->replaceTokenText($tokenText));
          $this->rpTokens[] = $newRPToken;
          return true;
        }
      }
    }
    return false;
  }

  /**
   * @param $tokenText
   *
   * @return string
   */
  protected static function replaceTokenText($tokenText): string {
        return '<span class="replaced-token">' . $tokenText . '</span>';
  }

}