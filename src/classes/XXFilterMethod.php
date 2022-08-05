<?php

use classes\tokenizer\ReplaceToken;

class XXFilterMethod extends AbstractFilterMethod {

  /**
   * @return void
   */
  public function makeReplacementTokens() {
    $wordTokenCount = 0;
    foreach($this->getTokenizer()->getTextTokens() as $textToken){
      $this->rpTokens[] = new ReplaceToken($textToken, $this->replaceTokenText($textToken->getToken()));
    }
  }

  /**
   * @param $tokenText
   *
   * @return string
   */
  protected static function replaceTokenText($tokenText): string {
        //return '<span style="color: purple">' . $tokenText . '</span>';
    return 'XXXX';
  }
  

}