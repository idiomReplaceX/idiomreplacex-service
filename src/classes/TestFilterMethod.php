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

    $chrArray = preg_split('//u', $this->text, -1, PREG_SPLIT_NO_EMPTY);

    $len = count($chrArray);
    for ($i = 0; $i < $len; $i++){
      $char = $chrArray[$i];
      if(TestFilterMethod::$HTML_EL_END == $char && $isHtmlElement){
        // reaching end of HTML element
        $isHtmlElement = false;
        $tokenStartPos = $i + 1;
      } else if(TestFilterMethod::$HTML_EL_START == $char){
        // start of HTML element
        $isHtmlElement = true;
        $this->makeReplacementToken($chrArray, $tokenStartPos, $i);
      } else if(!$isHtmlElement && $this->isWordBoundary($char) ){
        $this->makeReplacementToken($chrArray, $tokenStartPos, $i);
        $tokenStartPos = $i + 1;
      }
    }
  }

  protected function isWordBoundary($char): bool {
      return preg_match("/[[:space:]]/", $char);
      // return array_search($char, TestFilterMethod::$WHITESPACE_CHARS) !== false;
  }

  /**
   * @param int $startPos
   * @param int $endPos
   *
   * @return boolean
   *  TRUE if a new token has been created and added to the rpTokens list, otherwise FALSE
   */
  protected function makeReplacementToken(array $chrArray, int $startPos, int $endPos): bool {
    if ($startPos > -1 && $startPos < $endPos) {
      $tokenChars = array_slice($chrArray, $startPos, $endPos - $startPos);
      $tokenText = join($tokenChars);
      if(preg_match("/[[:alnum:]]/", $tokenText )){
        $this->wordTokenCount++;
        if($this->wordTokenCount % $this->markEveryNthWord == 0){
          $newRPToken = new ReplaceToken($startPos, $tokenText, $this->replaceTokenText($tokenText));
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
        //return '<span style="color: purple">' . $tokenText . '</span>';
    return '<span style="color: red">' . "Kackspecht" . '</span>';
  }

}