<?php

require_once "libs/dbconn.php";

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
        if ($this->validate_email() && $this->validate_username() && $this->validate_password()) {
            return true;
        } else {
            return false;
        }
    }
    
    // stub
    public function validate_email() {
        return true;
    }
    
    // stub
    public function validate_username() {
        if(strlen($this->username) < 20) {
            return true;
        } else {
            return false;
        }
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
                     "salasana" => password_hash($password, PASSWORD_BCRYPT), 
                     "käyttäjäryhmä" => "käyttäjä");
        
        $user = new User((object)$user_info);
        if($user->is_proper_user()) {
            $user->save();
        } else {
            return null;
        }
        return $user;
    }

    public function save() {
        // onko uusi käyttäjä
        if($this->id == -1) {
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
    
    public static function find($username, $password) {
        //$sql = "select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi = ? and salasana = ? limit 1";
        $sql = "select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi = ? limit 1";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($username));
        $result = $query->fetchObject();
        
        if ($result == null) {
            return null;
        } else {
            $user = new User($result);
            if (password_verify($password, $user->get_password())) {
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
    
    public function set_password($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
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
        return $this->group === "admin";
    }
}
