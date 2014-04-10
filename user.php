<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();

    function get_by_id() {
        if (empty($_GET["id"])) {
            return User::find_by_id(0);
        } else {
            return User::find_by_id(filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT));
        }
    }

    if (isset($_SESSION["current_user"]) && (filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT) || empty($_GET["id"]) && isset($_GET["id"]))) {
        $current_user = $_SESSION["current_user"];
        if ($current_user->is_admin()) {
            
            if (isset($_GET["remove"])) {
                $target_user = get_by_id();
                if($target_user->is_admin()) {
                    view("user", array("error", "Ylläpitäjiä ei voi poistaa.", "current_user" => $_SESSION["current_user"]));
                } else {
                    $target_user->delete();
                    view("user", array("success", "Käyttäjä " . $target_user->get_username() . " poistettu tietokannasta.", "current_user" => $_SESSION["current_user"]));
                }
            }
            
            if (isset($_POST["password"])) {
                $target_user = get_by_id();
                
                $target_user->set_password(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
                $target_user->save();
            }
            
            if (isset($_POST["email"])) {
                $target_user = get_by_id();
                
                if($target_user->get_email() != filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING)) {
                    $target_user->set_email(filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING));
                    $target_user->save();
                }
            }
        }
        
        $target_user = get_by_id();
        
        if($target_user != null) {
            view("user", array("target_user" => $target_user, "current_user" => $_SESSION["current_user"]));
        } else {
            view("user", array("error" => "Käyttäjää ei löytynyt.", "current_user" => $_SESSION["current_user"]));
        }
    }
    
    if (isset($_SESSION["current_user"]) && (!isset($_POST["email"]) || !isset($_POST["password"]))) {
        view("user", array("current_user" => $_SESSION["current_user"]));
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
                view("user", array("current_user" => $_SESSION["current_user"]));
            } else {
                $error = "Salasanojen on oltava samat.";
            }
        }
        view("user", array("error" => $error, "current_user" => $_SESSION["current_user"]));
    } else {
        header("Location: index.php");
    }
    
