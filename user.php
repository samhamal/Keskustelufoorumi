<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    if (isset($_SESSION["current_user"]) && (filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT) || empty($_GET["id"]) && isset($_GET["id"]))) {
        $current_user = $_SESSION["current_user"];
        if ($current_user->is_admin()) {
            if (isset($_POST["password"])) {
                if (empty($_GET["id"])) {
                    $user = User::find_by_id(0);
                } else {
                    $user = User::find_by_id(filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT));
                }
                
                $user->set_password(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
                $user->save();
            }
            
            if (isset($_POST["email"])) {
                if (empty($_GET["id"])) {
                    $user = User::find_by_id(0);
                } else {
                    $user = User::find_by_id(filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT));
                }
                
                $user->set_email(filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING));
                $user->save();
            }
        }
        
        if (empty($_GET["id"])) {
            $user = User::find_by_id(0);
        } else {
            $user = User::find_by_id(filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT));
        }
        
        if($user != null) {
            view("user", array("user" => $user, "current_user" => $_SESSION["current_user"]));
        } else {
            view("user", array("error" => "Käyttäjää ei löytynyt."));
        }
    }
    
    if (isset($_SESSION["current_user"]) && (!isset($_POST["email"]) || !isset($_POST["password"]))) {
        view("user", array("user" => $_SESSION["current_user"], "current_user" => $_SESSION["current_user"]));
    } else if (isset($_POST["email"]) || isset($_POST["password"])) {
        if(isset($_POST["email"]) && filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
            $current_user = $_SESSION["current_user"];
            $current_user->set_email(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
            $current_user->save();
            $_SESSION["current_user"] = $current_user;
            view("user", array("user" => $_SESSION["current_user"], "current_user", $_SESSION["current_user"]));
        }

        if (isset($_POST["password"]) && isset($_POST["password_confirm"])) {
            if ($_POST["password"] == $_POST["password_confirm"]) {
                $current_user = $_SESSION["current_user"];
                $current_user->set_password(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
                $current_user->save();
                $_SESSION["current_user"] = $current_user;
                view("user", array("user" => $_SESSION["current_user"], "current_user" => $_SESSION["current_user"]));
            } else {
                view("user", array("error" => "Salasanojen on oltava samat.", "user" => $_SESSION["current_user"]));
            }
        }
    } else {
        header("Location: index.php");
    }
    
