<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class ReplaceCSVFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {
        
        $datei = realpath(dirname(__FILE__))."/replace.csv";
        $repl_arr = [];
        if (($handle = fopen($datei, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $repl_arr[$data[0]??NULL] = $data[1]??"";
            }
            fclose($handle);
        }
        //if ($this->getSubfilter()==FilterMethods::TIPPEX) $rdel=30;
        //if ($this->getSubfilter()==FilterMethods::TIPPEX2) $rdel=11;
        
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $new = trim($textToken->getToken());
            if(isset($repl_arr[$new])) {
                $new_txt = $repl_arr[$new]??("XXXX".$new."XXX");
                $rpToken = new ReplaceToken($textToken, $this->replaceTokenText($new_txt));
                $this->rpTokens[] = $rpToken;
                
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
        return '<span style="color: red">' . $tokenText . '</span>';
    }

}
