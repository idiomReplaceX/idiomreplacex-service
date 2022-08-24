<?php

use classes\tokenizer\ReplaceToken;
use classes\tokenizer\HtmlTextTokenizer;

class TippExFilterMethod extends AbstractFilterMethod {

    /**
     * @return void
     */
    public function makeReplacementTokens() {

        if ($this->getSubfilter() == FilterMethods::FONTSIZE) {
            foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
                $new = $textToken->getToken();
                $zz = random_int(0, 20);
                if ($zz <= 10) {
                    //$fsize = random_int(15,40);
                    $chars = $this->str2arr($new);
                    $new = "";
                    foreach ($chars as $letter) {
                        $fsize = random_int(50, 250);
                        $new .= '<span style="font-size: ' . ($fsize / 100) . 'em;">' . $letter . '</span>';
                    }
                    $rpToken = new ReplaceToken($textToken, $new);
                    $this->rpTokens[] = $rpToken;
                }
            }
        } else {

            if ($this->getSubfilter() == FilterMethods::TIPPEX)
                $rdel = 30;
            if ($this->getSubfilter() == FilterMethods::TIPPEX2)
                $rdel = 11;

            foreach ($this->getTokenizer()->getTextTokens() as $textToken) {
                $new = $textToken->getToken();
                //delete or not?
                $zz = random_int(0, $rdel);
                if ($zz <= 10) {
                    $spaces = strlen($new);
                    $hlp = "";
                    while ($spaces > 0) {
                        $hlp .= "&nbsp;";
                        $spaces--;
                    }
                    $new = '<span style="background-color:#ccc;">' . $hlp . '</span>';
                    $rpToken = new ReplaceToken($textToken, $new);
                    $this->rpTokens[] = $rpToken;
                }
            }
        }
    }

    //UTF-8 safe string to array
    public function str2arr(string $str): array {
        $result = [];
        $len = mb_strlen($str, 'UTF-8');
        $result = [];
        for ($i = 0; $i < $len; $i++) {
            $result[] = mb_substr($str, $i, 1, 'UTF-8');
        }
        return $result;
    }

}
