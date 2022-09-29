<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;


class TextOffFilterMethod extends AbstractFilterMethod {

  /**
   * @return void
   */
  public function makeReplacementTokens() {
    foreach($this->getTokenizer()->getTextTokens() as $textToken){
        $newRPToken = new ReplaceToken($textToken, "");
        $this->rpTokens[] = $newRPToken;
    }
  }


}