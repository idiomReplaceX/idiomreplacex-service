<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class TippExFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {
        
        if ($this->getSubfilter()==FilterMethods::TIPPEX) $rdel=30;
        if ($this->getSubfilter()==FilterMethods::TIPPEX2) $rdel=11;
        
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $new = $textToken->getToken();
            //delete or not?
            $zz = random_int(0,$rdel);
            if($zz<=10) { 
                $spaces = strlen($new);
                $hlp="";
                while($spaces>0) { $hlp.="&nbsp;"; $spaces--; }
                $new= '<span style="background-color:#ccc;">'.$hlp.'</span>';
            }
            $rpToken = new ReplaceToken($textToken, $new);
            $this->rpTokens[] = $rpToken;
        }
            
    }

    /**
     * @param $tokenText
     *
     * @return string
     */
    protected static function replaceTokenText($tokenText): string {
        //return '<span style="color: purple">' . $tokenText . '</span>';
        return '<span style="color: red">' . "kkKackspecht" . '</span>';
    }

}
