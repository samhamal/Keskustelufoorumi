<?php

require_once "libs/dbconn.php";
require_once "libs/PasswordHash.php";

/**
 * Käyttäjän tiedot sisältävä luokka
 */
class User {
    
    private $id;
    private $username;
    private $password;
    private $group;
    private $email;
    private $error;
    
    /**
     * Luo uuden User olion
     * @param arrayobject $data luotavan käyttäjän tiedot
     */
    public function __construct($data) {
        $this->set_id($data->id);
        $this->set_username($data->käyttäjänimi);
        $this->set_password($data->salasana);
        $this->set_group($data->käyttäjäryhmä);
        $this->set_email($data->email);
    }
    
    /**
     * Apufunktio käyttäjän syöttämien tietojen tarkistamiseen uuden käyttäjän luontia varten.
     * @return true jos kaikki tiedot ovat oikein. false jos ei.
     */
    public function is_proper_user() {
        return ($this->validate_email() && $this->validate_username() && $this->validate_password());
    }
    
    /**
     * Tarkistaa, onko käyttäjän syöttämä email-osoite mahdollinen
     * @return true jos on, false jos ei
     */
    public function validate_email() {
        return true;
    }
    
    /**
     * Varmistaa käyttäjänimen sopivuuden tietokantaan, joka tukee vain alle 20 merkkisiä nimiä.
     * @return true jos käy, false jos ei.
     */
    public function validate_username() {
        return (strlen($this->username) < 20);
    }
    
    /**
     * Tynkä funktio, johon voisi lisätä salasanan vahvuuden tarkistuksen.
     * @return true jos salasana on sopiva, false jos ei.
     */
    public function validate_password() {
        return true;
    }
    
    /**
     * Yrittää luoda uuden käyttäjän.
     * @param type $username käyttäjänimi
     * @param type $email sähköposti
     * @param type $password salasana
     * @return Palauttaa User olion jos käyttäjän luominen onnistui, null jos ei.
     */
    public static function create($username, $email, $password) {
        $user_info = array(
                     "id" => -1, 
                     "käyttäjänimi" => $username, 
                     "email" => $email, 
                     "salasana" => $password, 
                     "käyttäjäryhmä" => "käyttäjä");
        
        $user = new User((object)$user_info);
        
        if ($user->is_proper_user()) {
            $user->save();
            return $user;
        } else {
            return null;
        }
    }
    
    /**
     * Päivittää käyttäjän tiedot.
     */
    private function update() {
        $params = array($this->get_username(), $this->get_email(), $this->get_password(), $this->get_id());
        sql_query("update käyttäjä set käyttäjänimi = ?, email = ?, salasana = ? where id = ?", null, $params);
    }
    
    /**
     * Syöttää uuden käyttäjän tietokantaan.
     */
    private function insert_new() {
        $params = array($this->get_username(), $this->get_group(), $this->get_email(), $this->get_password());
        $result = sql_query("insert into Käyttäjä(käyttäjänimi, käyttäjäryhmä, email, salasana) VALUES(?, ?, ?, ?) returning id", "column", $params);

        if ($result) {
            $this->id = $result;
        }
    }

    /**
     * Tallentaa käyttäjän.
     */
    public function save() {
        // onko uusi käyttäjä
        if ($this->id == -1) {
            $this->insert_new();
        } else {
            $this->update();
        }
    }
    
    /**
     * Etsii käyttäjän tämän käyttäjänimen perusteella
     * @param string $username käyttäjänimi
     * @return
     */
    public static function find_by_username($username) {
        return sql_query("select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi = ? limit 1",
                         "one", 
                         array($username));
    }
    
    /**
     * Etsii käyttäjän tämän idn perusteella
     * @param int $id
     * @return Palauttaa User olion tai null jos syötetyllä idllä ei löytynyt ketään
     */
    public static function find_by_id($id) {
        if($id != -1) {
            $result = sql_query("select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where id = ? limit 1", "one", array($id));

            if ($result == null) {
                return null;
            } else {
                $user = new User($result);
                return $user;        
            }
        } else {
            // todo: testaa
            // dummy käyttäjä joka näytetään poistetun käyttäjän viestien yhteydessä
            $user = new User(array("id" => -1, "email" => null, "käyttäjänimi" => "[poistettu]", "salasana" => null, "käyttäjäryhmä" => null));
        }
    }
    
    /**
     * Poista käyttäjä idn perusteella
     * @param int $id poistettavan käyttäjän id
     */
    public static function delete_by_id($id) {
        sql_query("delete from käyttäjä where id = ?", null, array($id));
    }
    
    /*
     * Poista käyttäjä
     */
    public function delete() {
        User::delete_by_id($this->id);
    }
    
    /**
     * Etsii useita käyttäjiä näiden käyttäjänimen perusteella.
     * @param string $username
     * @return palauttaa löydetyistä käyttäjistä tehdyn User oliotaulukon
     */
    public static function find_many($username) {
        $result = sql_query("select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi like ? order by käyttäjänimi", "all", array($username));
        $users = array();
        
        foreach($result as $user_data) {
            $users[] = (Object)(new User((Object)$user_data));
        }
        return $users;
    }
    
    /**
     * Kirjautumisfunktio
     * @param string $username käyttäjänimi
     * @param string $password tiivistämätön salasana
     * @return Palauttaa User olion jos kirjautuminen onnistui, muuten null
     */
    public static function login($username, $password) {
        $result = User::find_by_username($username);
        
        if ($result == null) {
            return null;
        } else {
            $user = new User($result);
            $hasher = new PasswordHash(8, false);
            
            $user->set_password_hashed($result->salasana);
            if ($hasher->CheckPassword($password, $user->get_password())) {
                return $user;
            } else {
                return null;
            }
        }
    }
    
    /**
     * Asettaa käyttäjän idn
     * @param int $id id
     */
    public function set_id($id) {
        $this->id = $id;
    }
    
    /**
     * Hae käyttäjän id
     * @return int id
     */
    public function get_id() {
        return $this->id;
    }
    
    /**
     * Asettaa käyttäjän käyttäjänimen
     * @param string $username käyttäjänimi
     */
    public function set_username($username) {
        $this->username = $username;
    }
    
    /**
     * Hae käyttäjän käyttäjänimi
     * @return string käyttäjänimi
     */
    public function get_username() {
        return $this->username;
    }
    
    /**
     * Asettaa käyttäjän salasanan
     * @param string $password valmiiksi tiivistetty salasana
     */
    public function set_password_hashed($password) {
        $this->password = $password;
    }
    
    /**
     * Asettaa käyttäjän salasanan
     * @param string $password tiivistämätön salasana
     */
    public function set_password($password) {
        $hasher = new PasswordHash(8, false);
        $this->password = $hasher->HashPassword($password);
    }
    
    /**
     * Hae käyttäjän salasana ( tiivistetty )
     * @return string salasana
     */
    public function get_password() {
        return $this->password;
    }
    
    /**
     * Asettaa käyttäjän käyttäjäryhmän
     * @param string $group käyttäjäryhmä
     */
    public function set_group($group) {
        $this->group = $group;
    }
    
    /**
     * Hae käyttäjän käyttäjäryhmä
     * @return string käyttäjäryhmä
     */
    public function get_group() {
        return $this->group;
    }
    
    /**
     * Asettaa käyttäjän sähköpostiosoitteen
     * @param string $email
     */
    public function set_email($email) {
        $this->email = $email;
    }
    
    /**
     * Hae käyttäjän sähköpostiosoite
     * @return string email
     */
    public function get_email() {
        return $this->email;
    }
    
    /**
     * Onko käyttäjä ylläpitäjä
     * @return boolean palauttaa true jos on, false jos ei.
     */
    public function is_admin() {
        return $this->group == "admin";
    }
}
