<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class ReplaceDbFilterMethod extends AbstractFilterMethod {

    
    private $filter_id = NULL;
    private $filter_art = NULL;
    private $filter_autorin = NULL;
    
    /**
     * @return void
     */
    public function makeReplacementTokens() {
        
        //Get Filter ID from Filtertext
        $db = new Db();
        $r = $db->queryRow("select * from ersetzungen_filter where filtername='".mysqli_real_escape_string($db->link,$this->getSubfilter())."'");
        if(!$r) return false;
        $this->filter_id = $r["id"];
        $this->filter_art = $r["art"];
        $this->filter_autorin = $r["autorin"];
        
        
        echo "ff".$this->getSubfilter().$this->filter_art;
            die();
            
            if($this->filter_art=="kontamination") {
                $r = $db->queryRow("select * from live where page='".mysqli_real_escape_string($db->link,$this->getDocumentId())."'");
                var_dump($r);
                die("nnj");
            }
        

            
        
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $new = self::replace($textToken->getToken());
            if (is_string($new)) {
                if(empty($new)) $new=(string)"";
                $rpToken = new ReplaceToken($textToken, $new);
                $this->rpTokens[] = $rpToken;
            }
        }
            
    }
    
    protected function replace($wort) {
        if (!empty($wort)) {
            $db = new Db();
            
            if($this->filter_art=="wort") {
                $sql = "SELECT ersatz FROM `ersetzungen` WHERE `cat` = " .$this->filter_id. " and `wort` = '" . mysqli_real_escape_string($db->link,$wort). "'";
                $row = $db->queryRow($sql);
                if(count($row)>0) {
                    return $row["ersatz"];
                } 
            }
            
            if($this->filter_art=="zeichen") {
                $sql = "SELECT wort,ersatz FROM `ersetzungen` WHERE `cat` = " .$this->filter_id;
                $result = mysqli_query($db->link,$sql);
                $wort_org = $wort;
                if($result) {
                    while ($row = $result->fetch_row()) {
                        //$list[] = $row[1]??"??";
                        $search = $row[0];
                        $replace = $row[1];
                        $wort = str_replace($search, $replace, $wort);
                    }
                }
                if($wort!=$wort_org) return $wort;
            }
            
        } else
            return false;
    }

    

}
