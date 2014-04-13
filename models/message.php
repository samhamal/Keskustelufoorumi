<?php

require_once "libs/common.php";
require_once "libs/dbconn.php";
require_once "models/user.php";

class Message {
    private $id;
    private $parent;
    private $children;
    private $owner;
    private $body;
    private $forum;
    private $title;
    private $sent;
    private $hidden;

    public function __construct($data) {
        $this->id = $data->id;
        $this->parent = $data->liitos_id;
        $this->owner = User::find_by_id($data->lähettäjä);
        $this->body = $data->sisältö;
        $this->title = $data->otsikko;
        $this->sent = date("d.m.y H:i:s", strtotime($data->lähetysaika));
        $this->forum = $data->aihealue;
        $this->hidden = $data->piilotettu;
        $this->children = array();
    }
    
    public static function create($message_body, $parent, $forum, $owner_id, $title = null) {
        if($title == null) {
            $sql = "insert into Viesti(sisältö, liitos_id, lähettäjä, lähetysaika, aihealue) VALUES(?, ?, ?, ?, ?) returning id";
            $query = get_db_connection()->prepare($sql);
            $query->execute(array($message_body, $parent->get_id(), $owner_id, date("Y-m-d H:i:s"), $forum));
        }
    }
    
    public function remove() {
        $sql = "select id from viesti where liitos_id = ?";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($this->id));
        $result = $query->fetchAll();
        
        if($result) {
            $this->hide();
        } else {
            $sql = "delete from viesti where id = ?";
            $query = get_db_connection()->prepare($sql);
            $query->execute(array($this->id));
        }
    }
    
    public function hide() {
        $sql = "update viesti set piilotettu = true where id = ?";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($this->id));
    }
    
    // todo: Hae tietyn käyttäjän kaikki viestit
    public static function get_by_user_id($id) {
        $messages = array();
        $sql = "select * from viesti where lähettäjä = ? order by id";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchAll();
        
        foreach($result as $message_data) {
            $messages[] = new Message((object)$message_data);
        }
        
        return $messages;
    }
    
    // hae yksittäinen viesti
    public static function get_by_id($id) {
        $sql = "select * from viesti where id = ? limit 1";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchObject();
        
        if($result) {
            return new Message((object)$result);
        } else {
            return null;
        }
    }
    
    // Hae koko viestiketju sen aloitusviestin idn perusteella
    public static function get_messages_by_topic($id) {
        $messages = array();
        $sql = "select * from hae_viestiketju(?, true) order by id";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchAll();
        
        foreach($result as $message_data) {
            $messages[] = new Message((object)$message_data);
        }
        
        foreach($messages as $message) {
            foreach($messages as $other_message) {
                if($other_message->get_parent() == $message->get_id()) {
                    $message->add_child($other_message);
                }
            }
        }
        return $messages;       
    }
    
    // Hae kaikki viestiketjujen aloitukset tietyltä foorumilta
    public static function get_topics_by_forum_id($id) {
        $sql = "select * from viesti where liitos_id is null and aihealue = ? order by id";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchAll();
        $topics = array();
        
        foreach($result as $topic_data) {
            $topics[] = (new Message((Object)$topic_data));
        }
        return $topics;
    }
    
    public function get_parent() {
        return $this->parent;
    }
    
    public function save() {
        $sql = "update viesti set sisältö = ? where id = ?";
        $query = get_db_connection()->prepare($sql);
        $result = $query->execute(array($this->get_body(), $this->get_id()));
    }
    
    public function set_body($message) {
        $this->body = $message;
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function set_id($id) {
        
    }
    
    public function get_title() {
        return htmlspecialchars($this->title);
    }
    
    public function get_forum() {
        return $this->forum;
    }
    
    public function get_owner() {
        return $this->owner;
    }
    
    public function get_body() {
        return htmlspecialchars($this->body);
    }
    
    public function get_sent() {
        return $this->sent;
    }
    
    public function add_child($message) {
        $this->children[] = $message->get_id();
    }
    
    public function get_children() {
        return $this->children;
    }
    
    public function is_hidden() {
        return $this->hidden;
    }
}