<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class BasisformFilterMethod extends AbstractFilterMethod {

    public function makeReplacementTokens() {
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $new = self::replace($textToken->getToken());
            if (strlen($new)>0) {
                $rpToken = new ReplaceToken($textToken, $new);
                $this->rpTokens[] = $rpToken;
            }
        }
    }

    protected static function replace($wort) {
        if (!empty($wort)) {
            $db = new Db();
            $rows = $db->queryRow("SELECT * FROM `word_mapping` WHERE `fullform` = '" . $wort . "'");
            if($rows!==false) {
            if (count($rows) > 0) {
                //Log::write("Basisform", $wort, "", $wort . " gefunden. " . print_r($rows, 1) . "---");
                if (isset($rows["baseform"])) {
                    return $rows["baseform"];
                }
            } else {
                //Log::write("Basisform", $wort, "", $wort . " nicht gefunden.");
                return false;
            }
            } 
        } else
            return false;
    }

}
