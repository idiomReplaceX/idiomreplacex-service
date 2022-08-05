<?php

namespace tokenizer;

use classes\tokenizer\TextToken;

class HtmlTextTokenizer {

  private $text =  null;
  private $textTokens = [];

  private static $HTML_EL_START = '<';
  private static $HTML_EL_END = '>';

  private static $satz_zeichen = ",.!?;:\"\')(»«";

  public function __construct(string $text) {
    $this->text =  $text;
    $this->parseText();
  }

  /**
   * @return string
   */
  public function getText(): string {
    return $this->text;
  }

  /**
   * @return array
   */
  public function getTextTokens(): array {
    return $this->textTokens;
  }

  /**
   * Walks the text and creates the list of ReplaceToken
   */
  protected function parseText() {

    $isHtmlElement = false;
    $tokenStartPos = 0;

    // split into unicode characters
    $chrArray = preg_split('//u', $this->text, -1, PREG_SPLIT_NO_EMPTY);

    $len = count($chrArray);
    for ($i = 0; $i < $len; $i++){
      $char = $chrArray[$i];
      if(HtmlTextTokenizer::$HTML_EL_END == $char && $isHtmlElement){
        // reaching end of HTML element
        $isHtmlElement = false;
        $tokenStartPos = $i + 1;
      } else if(HtmlTextTokenizer::$HTML_EL_START == $chrArray[$i] || isset($chrArray[$i + 1]) && $this->isSatzzeichen($chrArray, $i) &&  HtmlTextTokenizer::$HTML_EL_START == $chrArray[$i + 1]){
        // start of HTML element
        $isHtmlElement = true;
        $this->makeTextToken($chrArray, $tokenStartPos, $i);
        if($this->isSatzzeichen($chrArray, $i)){
          $i++;
        }
      } else if(!$isHtmlElement && $this->isWordBoundary($chrArray, $i) ){
        $this->makeTextToken($chrArray, $tokenStartPos, $i);
        if($this->isSatzzeichen($chrArray, $i)){
          $i++;
        }
        $tokenStartPos = $i + 1;
      }
    }
  }

  protected function isWordBoundary($chrArray, $pos): bool {
    return preg_match("/[[:space:]]/", $chrArray[$pos])
      ||
      ($this->isSatzzeichen($chrArray, $pos) && !isset($chrArray[$pos + 1]))
      ||
      (
        $this->isSatzzeichen($chrArray, $pos) && isset($chrArray[$pos + 1]) &&
        preg_match("/[[:space:]]/", $chrArray[$pos + 1])
      );
    // return array_search($char, TestFilterMethod::$WHITESPACE_CHARS) !== false;
  }

  protected function isSatzzeichen($chrArray, $pos): bool {
    return strpos(HtmlTextTokenizer::$satz_zeichen, $chrArray[$pos]) !== false;
  }



  /**
   * @param array $chrArray
   * @param int $startPos
   * @param int $endPos
   *
   * @return boolean
   *  TRUE if a new token has been created and added to the textTokens list, otherwise FALSE
   */
  protected function makeTextToken(array $chrArray, int $startPos, int $endPos): bool {
    if ($startPos > -1 && $startPos < $endPos) {
      $tokenChars = array_slice($chrArray, $startPos, $endPos - $startPos);
      $tokenText = join($tokenChars);
      if(preg_match("/[[:alnum:]]/", $tokenText )){
        $this->textTokens[] = new TextToken($startPos, $tokenText);;
        return true;
      }
    }
    return false;
  }

}