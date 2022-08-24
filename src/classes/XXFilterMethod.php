<?php

use classes\tokenizer\ReplaceToken;

class XXFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {
        $wordTokenCount = 0;
        $repl = "??";
        if ($this->getSubfilter() == FilterMethods::XX)
            $repl = 'XXXX';
        if ($this->getSubfilter() == FilterMethods::HILFE)
            $repl = 'HHHIIILLLFFFEEE';
        
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $this->rpTokens[] = new ReplaceToken($textToken, $repl);
        }
    }

}
