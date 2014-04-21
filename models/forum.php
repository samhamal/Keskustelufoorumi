<?php

require_once "libs/common.php";
require_once "libs/dbconn.php";

/**
 * Aihealueen tiedot sisältävä luokka
 */
class Forum {
    private $id;
    private $name;
    private $description;
    
    /**
     * Forum olion konstruktori
     * @param arrayobject $data luotavan aihealueen tiedot(id, nimi, kuvaus)
     */
    public function __construct($data) {
        $this->id = $data->id;
        $this->name = $data->nimi;
        $this->description = $data->kuvaus;
    }
    
    /**
     * Luo uusi Forum olio
     * @param int $id aihealueen id
     * @param string $title aihealueen otsikko
     * @param string $description aihealueen kuvaus
     */
    public static function create($id, $title, $description) {
        $forum_data = array(
                      "id" => $id,
                      "nimi" => $title,
                      "kuvaus" => $description);
        
        $forum = new Forum((object)$forum_data);
        
        return $forum;
    }
    
    /**
     * Tarkistaa Forum olion id kentän uniikkiuden tietokannassa
     * @param int $id aihealueen id
     * @return true jos on uniikki, false jos ei
     */
    public static function is_valid_id($id) {
        $result = sql_query("select id from aihealue where id = ?", "column", array($id));
        
        if($result == null) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Yrittää tallentaa Forum olion tietokantaan.
     * @return boolean true jos tallennus onnistuu, false jos ei
     */
    public function save() {
        if(Forum::is_valid_id($this->id)) {
            sql_query("insert into Aihealue(id, nimi, kuvaus) VALUES(?, ?, ?)", null, array($this->id, $this->name, $this->description));
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Päivittää Forum olion tietokantaan.
     */
    public function update() {
        sql_query("update aihealue set id = ?, nimi = ?, kuvaus = ? where id = ?", null, array($this->id, $this->name, $this->description, $this->id));
    }
    
    /**
     * Hae kaikki aihealueet
     * @return array oliotaulukko
     */
    public static function get_all() {
        $result = sql_query("select * from aihealue order by id", "all");
        $forums = array();
        
        foreach($result as $forum_data) {
            $forums[] = (Object)(new Forum((Object)$forum_data));
        }
        return $forums;
    }
    
    /**
     * Hae aihealue idn perusteella
     * @param int $id haettavan aihealueen id
     * @return palauttaa Forum olion jos haku onnistuu, null jos ei
     */
    public static function get_by_id($id) {
        $result = sql_query("select * from aihealue where id = ? limit 1", "one", array($id));
        
        if ($result == null) {
            return null;
        } else {
            return new Forum($result);
        }
    }
    
    /**
     * Poista aihealue idn perusteella
     * @param int $id poistettavan aihealueen id
     */
    public static function delete_by_id($id) {
        sql_query("delete from aihealue where id = ?", null, array($id));
    }
    
    /*
     * Poista aihealue ja kaikki siellä olevat viestit
     */
    public function delete() {
        $topics = Message::get_topics_by_forum_id($this->id);
        foreach($topics as $topic) {
            $replies = Message::get_messages_by_topic($topic->get_id());
            foreach($replies as $reply) {
                $reply->remove(true);
            }
        }
        Forum::delete_by_id($this->id);
    }
    
    /**
     * Hae aihealueen id
     * @return int aihealueen id
     */
    public function get_id() {
        return $this->id;
    }
    
    /**
     * Hae aihealueen otsikko
     * @return string aihealueen otsikko
     */
    public function get_name() {
        return $this->name;
    }
    
    /**
     * Hae aihealueen kuvaus
     * @return string aihealueen kuvaus
     */
    public function get_description() {
        return $this->description;
    }
    
}