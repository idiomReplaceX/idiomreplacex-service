<?php

class Db {
  
    const host = 'localhost';
    const db = 'openthesaurus';
    const user = 'openthesaurus';
    const pwd = 's8djr5G2WFUpbTTV';
    
    public $link;
    
    public function __construct() {
        $link = mysqli_connect(self::host, self::user, self::pwd);
        if (!$link) die('Verbindung schlug fehl: ' . mysqli_error($this->link));
        mysqli_select_db($link,self::db);
        $this->link = $link;
        return $this->link;
    }
    
    public function queryRows($sql) {
        $result = mysqli_query($this->link,$sql);
        if($result) {
            $rows = mysqli_fetch_array($result);
            if(!is_array($rows)) return [];
            else return $rows;
        }
        return false;
    }
    
    public function insert($sql) {
        if(mysqli_query($this->link, $sql)) return true; else die('Queryfehler: ' . mysqli_error($this->link));
    }
    
    
}