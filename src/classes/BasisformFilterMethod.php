<?php

use classes\tokenizer\ReplaceToken;

class BasisformFilterMethod implements IFilterMethod {

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
      if(self::$HTML_EL_END == $char && $isHtmlElement){
        // reaching end of HTML element
        $isHtmlElement = false;
        $tokenStartPos = $i + 1;
      } else if(self::$HTML_EL_START == $char){
        // start of HTML element
        $isHtmlElement = true;
        $this->makeReplacementToken($chrArray, $tokenStartPos, $i);
      } else if(!$isHtmlElement && $this->isWordBoundary($char)) {
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
   * @param array $chrArray
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
          
          if(!is_numeric($tokenText)) {
              $token_normalized = html_entity_decode($tokenText);
              if(strlen($token_normalized)>1) {
                  //Satzzeichen am Ende detektieren
                  $zeichen = $this->satzzeichen_remove($token_normalized);
                  $basisform = self::replace($zeichen);
                  if($basisform!==false) {
                    $this->rpTokens[] = new ReplaceToken($startPos, $tokenText, $basisform);
                    return true;
                  }
              }
          }
      }
    }
    return false;
  }
  
  public function satzzeichen_remove($text) {
      $zeichen = [",",".","!","?",";",":","\"","\'",")","(","»","«"];
      $found= [];
      foreach ($zeichen as $value) {
          $charpos = strrpos($text, $value);
          if($charpos!==false) {
              $found[$value] = $charpos;
              $text = str_replace($value, "", $text);
          }
      }
      $found["text"] = $text;
      return $found;
  }
  
  

 
  /**
   * @param $tokenText
   *
   * @return string
   */
  protected static function replaceTokenText($tokenText): string {
        //return '<span style="color: purple">' . $tokenText . '</span>';
    return '';
  }
  
  protected static function replace($zeichen) {
    
    if(!empty($zeichen["text"])) {
        $word = $zeichen["text"];
        $db = new Db();
        $rows = $db->queryRows("SELECT * FROM `word_mapping` WHERE `fullform` = '". $word."'");
        if(count($rows)>0) {
            Log::write("Basisform",$word,"",$word." gefunden. ".print_r($rows,1)."---".print_r($zeichen,1));
            if(isset($rows["baseform"])) {
                return $rows["baseform"];
            }
        } else {
            Log::write("Basisform",$word,"",$word." nicht gefunden.");
            return false;
        }
    } else return false;
      
  }
  

}