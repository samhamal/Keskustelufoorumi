<?php

require_once "libs/dbconn.php";
require_once "libs/PasswordHash.php";

class User {
    
    private $id;
    private $username;
    private $password;
    private $group;
    private $email;
    private $error;
    
    public function __construct($data) {
        $this->set_id($data->id);
        $this->set_username($data->käyttäjänimi);
        $this->set_password($data->salasana);
        $this->set_group($data->käyttäjäryhmä);
        $this->set_email($data->email);
    }
    
    public function is_proper_user() {
        return ($this->validate_email() && $this->validate_username() && $this->validate_password());
    }
    
    // stub
    public function validate_email() {
        return true;
    }
    
    public function validate_username() {
        return (strlen($this->username) < 20);
    }
    
    // stub
    public function validate_password() {
        return true;
    }
    
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

    public function save() {
        // onko uusi käyttäjä
        if ($this->id == -1) {
            $sql = "insert into Käyttäjä(käyttäjänimi, käyttäjäryhmä, email, salasana) VALUES(?, ?, ?, ?) returning id";
            $query = get_db_connection()->prepare($sql);
            $result = $query->execute(array($this->get_username(), $this->get_group(), $this->get_email(), $this->get_password()));
            
            if ($result) {
                $this->id = $query->fetchColumn();
            }
        } else {
            $sql = "update käyttäjä set käyttäjänimi = ?, email = ?, salasana = ? where id = ?";
            $query = get_db_connection()->prepare($sql);
            $result = $query->execute(array($this->get_username(), $this->get_email(), $this->get_password(), $this->get_id()));
        }
    }
    
    public static function find_one($username) {
        $sql = "select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi = ? limit 1";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($username));
        return $query->fetchObject();
    }
    
    public static function find_by_id($id) {
        if($id != -1) {
            $sql = "select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where id = ? limit 1";
            $query = get_db_connection()->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetchObject();

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
    
    public static function delete_by_id($id) {
        $sql = "delete from käyttäjä where id = ?";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($id));
    }
    
    public function delete() {
        User::delete_by_id($this->id);
    }
    
    public static function find_many($username) {
        $sql = "select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi like ? order by käyttäjänimi";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($username));
        $result = $query->fetchAll();
        $users = array();
        
        foreach($result as $user_data) {
            $users[] = (Object)(new User((Object)$user_data));
        }
        return $users;
    }
    
    public static function login($username, $password) {
        $result = User::find_one($username);
        
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
    
    public function set_id($id) {
        $this->id = $id;
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function set_username($username) {
        $this->username = $username;
    }
    
    public function get_username() {
        return $this->username;
    }
    
    /**
     * @param valmiiksi tiivistetty salasana
     */
    public function set_password_hashed($password) {
        $this->password = $password;
    }
    
    /**
     * @param tiivistämätön salasana
     */
    public function set_password($password) {
        $hasher = new PasswordHash(8, false);
        $this->password = $hasher->HashPassword($password);
    }
    
    public function get_password() {
        return $this->password;
    }
    
    public function set_group($group) {
        $this->group = $group;
    }
    
    public function get_group() {
        return $this->group;
    }
    
    public function set_email($email) {
        $this->email = $email;
    }
    
    public function get_email() {
        return $this->email;
    }
    
    public function is_admin() {
        return $this->group == "admin";
    }
}
