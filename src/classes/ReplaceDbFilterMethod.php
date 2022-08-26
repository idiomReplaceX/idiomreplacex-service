<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class ReplaceDbFilterMethod extends AbstractFilterMethod {

    
    private $filter_id = NULL;
    
    /**
     * @return void
     */
    public function makeReplacementTokens() {
        
        //Get Filter ID from Filtertext
        $db = new Db();
        $r = $db->queryRow("select id from ersetzungen_filter where filtername='".mysqli_real_escape_string($db->link,$this->getSubfilter())."'");
        if(!$r) return false;
        $this->filter_id = $r["id"];
        
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $new = self::replace($textToken->getToken());
            if (strlen($new)>0) {
                $rpToken = new ReplaceToken($textToken, $new);
                $this->rpTokens[] = $rpToken;
            }
        }
            
    }
    
    protected function replace($wort) {
        if (!empty($wort)) {
            $db = new Db();
            $sql = "SELECT ersatz FROM `ersetzungen` WHERE `cat` = " .$this->filter_id. " and `wort` = '" . mysqli_real_escape_string($db->link,$wort). "'";
            $row = $db->queryRow($sql);
            if(!empty($row)) {
                return $row["ersatz"];
            } 
        } else
            return false;
    }

    

}
