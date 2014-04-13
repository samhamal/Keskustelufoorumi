<?php

require_once "libs/dbconn.php";

class Forum {
    private $id;
    private $name;
    private $description;
    
    public function __construct($data) {
        $this->id = $data->id;
        $this->name = $data->nimi;
        $this->description = $data->kuvaus;
    }
    
    public static function get_all() {
        $sql = "select * from aihealue order by id";
        $query = get_db_connection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $forums = array();
        
        foreach($result as $forum_data) {
            $forums[] = (Object)(new Forum((Object)$forum_data));
        }
        return $forums;
    }
    
    public static function get_by_id($id) {
        $sql = "select * from aihealue where id = ? limit 1";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchObject();
        
        if ($result == null) {
            return null;
        } else {
            return new Forum($result);
        }
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_description() {
        return $this->description;
    }
    
}