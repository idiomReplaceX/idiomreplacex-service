<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class ReplaceDbFilterMethod extends AbstractFilterMethod {

    
    private $filter_id = NULL;
    private $filter_art = NULL;
    private $filter_autorin = NULL;
    
    private $counter = 0;
    private $txt;
    private $live_id;
    
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
        
        //Track request for re-use and multi filters
        //Lock database because of asynchron request
        $sql = "select * from live where NOW() < DATE_ADD( zeit, INTERVAL 2 MINUTE ) and ip='".$_SERVER['REMOTE_ADDR']."' and filter_id='".$this->filter_id."' and page='".mysqli_real_escape_string($db->link,$this->getDocumentId())."'";
        //Log::file("Filter : ".$this->getSubfilter()." - ".$_SERVER['REMOTE_ADDR']." page ".$this->getDocumentId());
        mysqli_query($db->link, "LOCK TABLE live WRITE;");
        $r = $db->queryRow($sql);
        if(!empty($r["id"])) {
            $this->counter = $r["counter"]??1;
            $this->txt = $r["txt"]??NULL;
            $this->live_id = $r["id"];
            //Log::file("Found: ".$this->live_id);
        } else {
            $this->counter = 1;
            $this->txt = NULL;
            $sql = "insert into live set zeit='".date("Y-m-d H:i:s")."',filter_id='".$this->filter_id."',filter='".$this->getSubfilter()."',ip='".$_SERVER['REMOTE_ADDR']."',page=".mysqli_real_escape_string($db->link,$this->getDocumentId());
            mysqli_query($db->link, $sql);
            $this->live_id = mysqli_insert_id($db->link);
            //Log::file("created new: ".$this->live_id);
        }
        mysqli_query($db->link, "UNLOCK TABLES;");
        
        
        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            $new = self::replace($textToken->getToken());
            if (is_string($new)) {
                if(empty($new)) $new=(string)"";
                $rpToken = new ReplaceToken($textToken, $new);
                $this->rpTokens[] = $rpToken;
            }
        }
        
        if($this->live_id) {
         if(!empty($this->live_id)) $sql = "update live set zeit='".date("Y-m-d H:i:s")."',counter='".$this->counter."',txt='".$this->txt."' where id=".$this->live_id;
         mysqli_query($db->link, $sql);
         //Log::file("Update:".$this->live_id);
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
            
            if($this->filter_art=="blubbern") {
                $sql = "SELECT ersatz FROM `ersetzungen` WHERE `cat` = " .$this->filter_id. " and `wort` = '" . mysqli_real_escape_string($db->link,$wort). "'";
                $row = $db->queryRow($sql);
                if(count($row)>0) {
                    $this->counter++;
                    return str_repeat($row["ersatz"]." ", $this->counter);
                } 
            }
            
            if($this->filter_art=="kontamination") {
                
                
                $sql = "SELECT ersatz FROM `ersetzungen` WHERE `cat` = " .$this->filter_id;
                $row = $db->queryRow($sql);
                if(count($row)>0) {
                    if(empty($this->txt)) $this->txt = $row["ersatz"];
                    else {
                        //take some word and display
                        
                        return str_repeat($row["ersatz"]." ", $this->counter);
                    }
                    $this->counter++;
                } 
            }
            
        } else
            return false;
    }

    

}
