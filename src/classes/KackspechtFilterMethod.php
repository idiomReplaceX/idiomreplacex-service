<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;


class KackspechtFilterMethod extends AbstractFilterMethod {

  private $markEveryNthWord = 2;

  /**
   * @return void
   */
  public function makeReplacementTokens() {
    $wordTokenCount = 0;
    foreach($this->getTokenizer()->getTextTokens() as $textToken){
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