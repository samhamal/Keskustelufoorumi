<?php

require_once "libs/common.php";
require_once "libs/dbconn.php";

/**
 * Viestin tiedot sisältävä luokka
 */
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

    /**
     * Luo uuden Message olion annetuilla parametreilla
     * @param arrayobject $data luotavan viestin tiedot
     */
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
    
    /**
     * Syöttä vastaus tietokantaan
     * @param array $params
     */
    public static function create_reply($params) {
        sql_query("insert into Viesti(sisältö, liitos_id, lähettäjä, lähetysaika, aihealue) VALUES(?, ?, ?, ?, ?) returning id", null, $params);
    }
    
    /**
     * Luo uusi vastausviesti tai viestiketju annetuilla parametreilla
     * @param type $message_body viestin sisältö
     * @param type $parent toisen viestin id, jos luotava viesti on vastaus johonkin toiseen
     * @param type $forum aihealue
     * @param type $owner_id viestin lähettäneen käyttäjän id
     * @param type $title viestin otsikko, jos viesti on viestiketjun aloitus
     * @return Palauttaa Message olion vain uutta viestiketjua tehtäessä
     */
    public static function create($message_body, $parent, $forum, $owner_id, $title = null) {
        if($title == null) {
            Message::create_reply(array($message_body, $parent->get_id(), $owner_id, date("Y-m-d H:i:s"), $forum));
        } else {
            $topic_info = array(
                     "id" => -1, 
                     "otsikko" => $title, 
                     "sisältö" => $message_body, 
                     "liitos_id" => null, 
                     "lähettäjä" => $owner_id,
                     "lähetysaika" => date("Y-m-d H:i:s"),
                     "piilotettu" => false,
                     "aihealue" => $forum);
        
            $topic = new Message((object)$topic_info);
            $params = array($title, $message_body, null, $owner_id, date("Y-m-d H:i:s"), $forum);
            $sql = "insert into Viesti(otsikko, sisältö, liitos_id, lähettäjä, lähetysaika, aihealue) VALUES(?, ?, ?, ?, ?, ?) returning id";
            $result = sql_query($sql, "column", $params);
            
            if ($result) {
                $topic->set_id($result);
                return $topic;
            }
        }
    }
    
    /**
     * Poistaa viestin jos sillä ei ole vastauksia, muuten piilottaa.
     * @param boolean $force pakota tietokannasta poistaminen
     */
    public function remove($force = false) {
        if($force == false) {
            $result = sql_query("select id from viesti where liitos_id = ?", "all", array($this->get_id()));
            
            if(!empty($result)) {
                $this->hide();
                return;
            }
        }
        
        delete: {
            sql_query("delete from viesti where id = ?", null, array($this->get_id()));
        }
    }
    
    /**
     * Piilota viesti
     */
    public function hide() {
        sql_query("update viesti set piilotettu = true where id = ?", null, array($this->get_id()));
    }
    
    /**
     * Hae tietyn käyttäjän kaikki viestit idn perusteella
     * @param int $id käyttäjän id
     * @return palauttaa oliotaulukon käyttäjän lähettämistä viesteistä
     */
    public static function get_by_user_id($id) {
        $result = sql_query("select * from viesti where lähettäjä = ? order by id", "all", array($id));
        
        return Message::object_array_from_array($result);
    }
    
    /**
     * Hae yksittäinen viesti idn perusteella
     * @param int $id viestin id
     * @return Palauttaa Message olion jos viesti löytyi, null jos ei
     */
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
    
    /**
     * Hakee yhden viestiketjun kaikki viestit aloitusviestin idn perusteella
     * @param int $id aloitusviestin id
     * @return Oliotaulukko viestiketjun viesteistä
     */
    public static function get_messages_by_topic($id) {
        $result = sql_query("select * from hae_viestiketju(?, true) order by id", "all", array($id));
        $messages = Message::object_array_from_array($result);
        
        return $messages;       
    }
    
    /**
     * TODO: Hae kaikki viestiketjut joita tietty käyttäjä ei ole vielä lukenut
     * @param int $user käyttäjän id
     */
    public static function get_unread_topics($user_id) {
        $sql = "select * from viesti where viesti.piilotettu = false and viesti.liitos_id is null and viesti.id not in (select viesti.id from viesti, luettuviesti where luettuviesti.viesti = viesti.id and luettuviesti.käyttäjä = ?)";
        $result = sql_query($sql, "all", array($user_id));
        return Message::object_array_from_array($result);
    }
    
    /**
     * Hae viimeisimmät viestiketjut
     * @param int $count haettavien viestiketjujen määrä
     * @return Palauttaa oliotaulukon viesteistä järjestettynä idn mukaan
     */
    public static function get_latest_topics($count) {
        $result = sql_query("select * from viesti where liitos_id is null order by id desc limit ?", "all", array($count));
        return Message::object_array_from_array($result);
    }
    
    /**
     * Hae kaikki viestiketjut tietyltä aihealueelta idn perusteella
     * @param int $id aihealueen id
     * @return Palauttaa oliotaulukon viesteistä
     */
    public static function get_topics_by_forum_id($id) {
        $result = sql_query("select * from viesti where liitos_id is null and aihealue = ? order by id desc", "all", array($id));
        return Message::object_array_from_array($result);
    }
    
    /**
     * Hae kaikki viestiketjut.
     * @return Palauttaa oliotaulukon kaikista viestiketjujen aloituksista.
     */
    public static function get_all_topics() {
        $result = sql_query("select * from viesti where liitos_id is null order by id desc", "all");
        return Message::object_array_from_array($result);
    }
    
    /**
     * Luo oliotaulukko parametrina annetusta taulukosta
     * @param array $array 
     * @return array Message oliotaulukko
     */
    public static function object_array_from_array($array) {
        $messages = array();
        
        foreach($array as $message_data) {
            $messages[] = new Message((object)$message_data);
        }
        return $messages;
    }
    
    /**
     * Hae kaikki käyttäjän viestiketjut
     * @param string $sender_name käyttäjän nimi
     * @return array Message oliotaulukko
     */
    public static function search_topic_by_sender($sender_name) {
        $user = User::find_by_username($sender_name);
        if($user != null) {
            $result = sql_query("select * from viesti where liitos_id is null and lähettäjä = ? order by id desc", "all", array($user->get_id()));
            return Message::object_array_from_array($result);
        } else {
            return null;
        }
    }
    
    /**
     * Hae viestiketjuja otsikon perusteella
     * @param string $title viestiketjun otsikko
     * @return array Message oliotaulukko
     */
    public static function search_topic_by_title($title) {
        $result = sql_query("select * from viesti where liitos_id is null and otsikko = ? order by id desc", "all", array($title));
        return Message::object_array_from_array($result);
    }
    
    /**
     * Hae viesti johon tämä viesti on vastaus
     * @return viestin id
     */
    public function get_parent() {
        return $this->parent;
    }
    
    /**
     * Tallentaa viestiin tehdyt muokkaukset tietokantaan
     */
    public function save() {
        sql_query("update viesti set sisältö = ? where id = ?", null, array($this->get_body(), $this->get_id()));
    }
    
    /**
     * Aseta viestin sisältö
     * @param string $message sisältö
     */
    public function set_body($message) {
        $this->body = $message;
    }
    
    /**
     * Hae viestin id
     * @return int id
     */
    public function get_id() {
        return $this->id;
    }
    
    /**
     * Aseta viestin id 
     * @param int $id viestin id
     */
    public function set_id($id) {
        $this->id = $id;
    }
    
    /**
     * Hae viestin otsikko
     * @return string otsikko
     */
    public function get_title() {
        return htmlspecialchars($this->title);
    }
    
    /**
     * Hae viestin aihealue
     * @return int aihealueen id
     */
    public function get_forum() {
        return $this->forum;
    }
    
    /**
     * Hae viestin lähettäjä
     * @return User käyttäjäolio
     */
    public function get_owner() {
        return $this->owner;
    }
    
    /**
     * Hae viestin sisältö
     * @return string sisältö
     */
    public function get_body() {
        return htmlspecialchars($this->body);
    }
    
    /**
     * Hae viestin lähetysaika
     * @return Date lähetysaika
     */
    public function get_sent() {
        return $this->sent;
    }
    
    /**
     * Onko viesti piilotettu
     * @return boolean true jos on, false jos ei
     */
    public function is_hidden() {
        return $this->hidden;
    }
}