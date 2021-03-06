<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/message.php";
    require "models/forum.php";
    session_start();

    if (isset($_SESSION["current_user"]) && (filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT) || empty($_GET["id"]) && isset($_GET["id"]))) {
        $current_user = $_SESSION["current_user"];
        if ($current_user->is_admin()) {
            
            // todo: käy läpi viestit ja tyhjennä niiden sisältö
            if (isset($_GET["remove"])) {
                $target_user = User::find_by_id(parse_id("id"));
                if($target_user->is_admin()) {
                    view("user", array("error", "Ylläpitäjiä ei voi poistaa.", "current_user" => $_SESSION["current_user"]));
                } else {
                    $target_user->delete();
                    view("user", array("success", "Käyttäjä " . $target_user->get_username() . " poistettu tietokannasta.", "current_user" => $_SESSION["current_user"]));
                }
            }
            
            if (isset($_POST["password"])) {
                $target_user = User::find_by_id(parse_id("id"));
                
                $target_user->set_password(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
                $target_user->save();
            }
            
            if (isset($_POST["email"])) {
                $target_user = User::find_by_id(parse_id("id"));
                
                if($target_user->get_email() != filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING)) {
                    $target_user->set_email(filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING));
                    $target_user->save();
                }
            }
        }
        
        $target_user = User::find_by_id(parse_id("id"));
        
        if($target_user != null) {
            // hae käyttäjän viestiketjut
            $messages = Message::get_by_user_id($target_user->get_id());
            $forums = Forum::get_all_as_array();
            
            view("user", array("target_user" => $target_user, "current_user" => $_SESSION["current_user"], "messages" => $messages, "forums" => $forums));
        } else {
            view("user", array("error" => "Käyttäjää ei löytynyt.", "current_user" => $_SESSION["current_user"]));
        }
    }
    
    if (isset($_SESSION["current_user"]) && (!isset($_POST["email"]) || !isset($_POST["password"]))) {
        $user = $_SESSION["current_user"];
        $messages = Message::get_by_user_id($user->get_id());
        $forums = Forum::get_all_as_array();
        
        view("user", array("current_user" => $_SESSION["current_user"], "messages" => $messages, "forums" => $forums));
    } else if (isset($_POST["email"]) || isset($_POST["password"])) {
        $error = null;
        if(isset($_POST["email"]) && filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
            $current_user = $_SESSION["current_user"];
            
            if($current_user->get_email() != filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
                $current_user->set_email(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
                $current_user->save();
                $_SESSION["current_user"] = $current_user;
            }
        }

        if (isset($_POST["password"]) && isset($_POST["password_confirm"])) {
            if ($_POST["password"] == $_POST["password_confirm"]) {
                $current_user = $_SESSION["current_user"];
                $current_user->set_password(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
                $current_user->save();
                $_SESSION["current_user"] = $current_user;
                $messages = Message::get_by_user_id($current_user->get_id());
                $forums = Forum::get_all_as_array();
                view("user", array("current_user" => $_SESSION["current_user"], "messages" => $messages, "forums" => $forums));
            } else {
                $error = "Salasanojen on oltava samat.";
            }
        }
        $messages = Message::get_by_user_id($current_user->get_id());
        $forums = Forum::get_all();
        view("user", array("error" => $error, "current_user" => $_SESSION["current_user"], "messages" => $messages, "forums" => $forums));
    } else {
        header("Location: index.php");
    }
    
