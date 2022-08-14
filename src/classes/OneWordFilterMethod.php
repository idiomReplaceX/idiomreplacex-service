<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class OneWordFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {

        $replace = [];
        
        //Klarspüler
        if ($this->getSubfilter()==FilterMethods::KLARSPUELER) $replace=["b"=>"ph","v"=>"f","w"=>"f","d"=>"t"];

        //Weichspüler
        if ($this->getSubfilter()==FilterMethods::WEICHSPUELER) $replace=["k"=>"g","h"=>"b","p"=>"b","f"=>"w","t"=>"d"];

        //Vernis
        if ($this->getSubfilter()==FilterMethods::VERNIS) $replace=["i"=>"y"];

        //Polynesien
        //k und t vertauschen mit Hilfzeichen 
        if ($this->getSubfilter()==FilterMethods::POLYNESIEN) $replace=["k"=>"###","t"=>"k","###"=>"t"];

        
        // $replace = ["b" => "ph", "v" => "f", "w" => "f", "d" => "t"];
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {

            $changed = false;
            foreach ($replace as $key => $value) {
                if (strpos($textToken->getToken(), $key)) {
                    $changed = true;
                    $new_token = str_replace($key, $value, $textToken->getToken());
                }
            }
            if ($changed) {
                $rpToken = new ReplaceToken($textToken, $new_token);
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
        return '<span style="color: red">' . "kkKackspecht" . '</span>';
    }

}
