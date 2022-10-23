<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class OneWordFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {
        
        if ($this->getSubfilter()==FilterMethods::LESEBRILLE) {
            foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
                $mix = utf8_decode($textToken->getToken());
                if(strlen($mix)>4) {
                    $mixarr = str_split($mix);
                    $new = $mixarr[0];
                    unset($mixarr[0]);
                    $anz = count($mixarr);
                    $last = $mixarr[$anz];
                    unset($mixarr[$anz]);
                    $anz--;
                    //$debug.="NEW: ".$new."\n ARR".print_r($mixarr,1)."anz: ".$anz;
                    shuffle($mixarr);
                    $new.= join("", $mixarr);
                    $new.=$last;
                    //$debug.="FINAL: ".$new."\n";
                    //Log::write("Lesebrille",$new,$tokenText,$debug);
                    $rpToken = new ReplaceToken($textToken, utf8_encode($new));
                    $this->rpTokens[] = $rpToken;
                }
            }
            
        } else {
            
            $replace = [];

            //Klarspüler
            if ($this->getSubfilter()==FilterMethods::KLARSPUELER) $replace=["b"=>"ph","v"=>"f","w"=>"f","d"=>"t"];

            //Weichspüler
            if ($this->getSubfilter()==FilterMethods::WEICHSPUELER) $replace=["k"=>"g","h"=>"b","p"=>"b","f"=>"w","t"=>"d"];

            //Vernis
            if ($this->getSubfilter()==FilterMethods::VERNIS) $replace=["i"=>"y"];

            //Polynesien
            if ($this->getSubfilter()==FilterMethods::POLYNESIEN) $replace=["k"=>"###","t"=>"k","###"=>"t"];
            
            //Pocken
            if ($this->getSubfilter()==FilterMethods::POCKEN) $replace=["i"=>"<span style='color: red;'>i</span>"];


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
