<?php

class Log {
  
    
    public static function write($art,$original,$neu,$history) {
        $datum = date("Y-m-d H:i:s");
        $db = new Db();
        $db->insert("INSERT INTO log (datum,art,original,neu,history) VALUES ('".$datum."','".$art."','".$original."','".$neu."','".$history."')");
    }
    
}