<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class NoVerbFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {


        foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
            
            //Verben aus
            if ($this->getSubfilter() == FilterMethods::NOVERB) {
                if (self::isVerb($textToken->getToken())) {
                    $this->rpTokens[] = new ReplaceToken($textToken, "");
                }
            }
            
            //Verben mixen
            if ($this->getSubfilter() == FilterMethods::MULTIMIX) {
                $res = self::multiMix($textToken->getToken());
                if (!empty($res))
                    $this->rpTokens[] = new ReplaceToken($textToken, $res);
            }
            
        }

    }


    protected static function isVerb($word) {
        $db = new Db();
        $sql = "SELECT * FROM `verben` WHERE `form` = '" . $word . "'";
        $anz = $db->count($sql);
        if ($anz > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    protected static function isNomen($word) {
        $db = new Db();
        $sql = "SELECT * FROM `nomen` WHERE `form` = '" . $word . "'";
        $anz = $db->count($sql);
        if ($anz > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected static function multiMix($word) {
        if(self::isVerb($word)) {
            $db = new Db();
            
            $res1 = $db->queryRow("SELECT tags FROM `verben` WHERE `form` = '" . $word . "'");
            $tags=$res1["tags"]??false;
            
            if($tags) {
                //Fast Random selection in big database
                // Database is not changing, replace SELECT MAX(id) FROM verben -> 1211160
                $sql2 = "SELECT *
                        FROM verben r1
                        JOIN (
                          SELECT CEIL(RAND() * 2376740) AS idn 
                        ) AS r2 ON r1.id >= r2.idn 
                        WHERE tags='".$tags."'
                        ORDER BY id ASC LIMIT 0,1;"; 
                $res = $db->queryRow($sql2);
            return $res["form"] ?? "schlafen";
            }
            
        } 
        
        if(self::isNomen($word)) {
            $db = new Db();
            
            $res1 = $db->queryRow("SELECT tags FROM `nomen` WHERE `form` = '" . $word . "'");
            $tags=$res1["tags"]??false;
            
            if($tags) {
                //Fast Random selection in big database SUB:AKK:SIN:MAS
                // Database is not changing, replace SELECT MAX(id) FROM nomen -> 1211160
                $sql2 = "SELECT *
                        FROM nomen r1
                        JOIN (
                          SELECT CEIL(RAND() * 1211160) AS idn 
                        ) AS r2 ON r1.id >= r2.idn 
                        WHERE tags='".$tags."'
                        ORDER BY id ASC LIMIT 0,1;"; 
                $res = $db->queryRow($sql2);
            return $res["form"] ?? "Haustier";
            }
            
        } 
        return NULL;
        
    }

}
