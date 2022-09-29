<?php

class Log {

    public static function write($art, $original, $neu, $history) {
        $datum = date("Y-m-d H:i:s");
        $db = new Db();
        $db->insert("INSERT INTO log (datum,art,original,neu,history) VALUES ('" . $datum . "','" . $art . "','" . $original . "','" . $neu . "','" . $history . "')");
    }

    public static function file($line) {
        $file = '/usr/home/idiomx/public_html/idiom-redaktion/yii2-irx/views/site/log.txt';
        if (!$fp = fopen($file, 'a')) return;
        $txt = date("d.m.Y H:i:s")." - ".$line."<br />";
        fwrite($fp, $txt);
    }

}
