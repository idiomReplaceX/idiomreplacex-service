<?php

class Db {
  
    const host = 'localhost';
    const db = 'idiomx';
    const user = 'idiomx';
    const pwd = 'kXwq7HUrR1DPXez7';
    
    public $link;
    
    public function __construct() {
        $link = mysqli_connect(self::host, self::user, self::pwd);
        if (!$link) die('Verbindung schlug fehl: ' . mysqli_error($this->link));
        mysqli_select_db($link,self::db);
        $this->link = $link;
        return $this->link;
    }
    
    public function queryRow($sql) {
        $result = mysqli_query($this->link,$sql);
        if($result) {
            $rows = mysqli_fetch_array($result);
            if(!is_array($rows)) return [];
            else return $rows;
        }
        return false;
    }
    
    public function count($sql) {
        $result = mysqli_query($this->link,$sql);
        if($result) {
            return mysqli_num_rows($result);
            mysqli_free_result($result);
        }
        return false;
    }
    
    public static function getFilter() {
        $db = new self();
        $result = mysqli_query($db->link,"select * from ersetzungen_filter");
        $list = [];
        if($result) {
            while ($row = $result->fetch_row()) {
                $list[] = $row[1]??"??";
            }
        }
        return $list;
    }
    
    public function insert($sql) {
        if(mysqli_query($this->link, $sql)) return true; else die('Queryfehler: ' . mysqli_error($this->link));
    }
    
    
}