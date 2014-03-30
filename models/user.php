<?php

require_once "libs/dbconn.php";

class User {
    
    private $id;
    private $username;
    private $password;
    private $group;
    private $email;
    
    public static function find_user($username, $password) {
        $sql = "select id, email, käyttäjänimi, salasana, käyttäjäryhmä from käyttäjä where käyttäjänimi = ? and salasana = ? limit 1";
        $query = get_db_connection()->prepare($sql);
        $query->execute(array($username, $password));
        $result = $query->fetchObject();
        
        if ($result === null) {
            return null;
        } else {
            $user = new User();
            $user->set_id($result->id);
            $user->set_username($result->käyttäjänimi);
            $user->set_password($result->salasana);
            $user->set_group($result->käyttäjäryhmä);
            $user->set_email($result->email);
            return $user;
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
        $this->password = $password;
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
