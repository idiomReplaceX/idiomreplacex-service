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
            if ($this->getSubfilter() == FilterMethods::VERBMIX) {
                $res = self::verbMix($textToken->getToken());
                if (!empty($res))
                    $this->rpTokens[] = new ReplaceToken($textToken, $res);
            }
            
        }

    }


    protected static function isVerb($word) {
        $db = new Db();
        $anz = $db->count("SELECT * FROM `verben` WHERE `form` = '" . strtolower($word) . "'");
        if ($anz > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected static function verbMix($word) {
        if(self::isVerb($word)) {
            $db = new Db();
            
            //Fast Random selection in big database
            $sql2 = "SELECT *
  FROM verben AS r1 JOIN
       (SELECT (RAND() *
                     (SELECT MAX(id)
                        FROM verben)) AS id)
        AS r2
 WHERE r1.id >= r2.id
 ORDER BY r1.id ASC
 LIMIT 1;";
            $res = $db->queryRow($sql2);
            return $res["form"] ?? "?????";
        } else return NULL;
    }

}
