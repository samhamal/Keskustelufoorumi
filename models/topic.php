<?php

require_once "libs/dbconn.php";

class Topic {
    private $id;
    private $forum;
    private $topic;
    private $sent;
    private $hidden;
    
    public static function get_by_id($id) {
        
    }
    
    public static function get_by_forum_id($id) {
        $sql = "select * from aihealue order by id";
        $query = get_db_connection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        $forums = array();
        
        foreach($result as $forum_data) {
            $forums[] = (Object)(new Forum((Object)$forum_data));
        }
        return $topics;
    }
}