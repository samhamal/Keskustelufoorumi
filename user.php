<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    

    
    // todo: hae toisen käyttäjän tiedot
    if(isset($_GET["id"])) {
        
    }
    
    if(isset($_SESSION["current_user"]) && (!isset($_POST["email"]) || !isset($_POST["password"]))) {
        view("user", array("user" => $_SESSION["current_user"]));
    } else if (isset($_POST["email"]) || isset($_POST["password"])) {
        if(isset($_POST["email"]) && filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)) {
            $user = $_SESSION["current_user"];
            $user->set_email(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
            $user->save();
            $_SESSION["current_user"] = $user;
        }

        if(isset($_POST["password"]) && isset($_POST["password_confirm"])) {
            if($_POST["password"] == $_POST["password_confirm"]) {
                $user = $_SESSION["current_user"];
                $user->set_password(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
                $user->save();
                $_SESSION["current_user"] = $user;
            } else {
                view("user", array("error" => "Salasanojen on oltava samat.", "user" => $_SESSION["current_user"]));
            }
        }
    } else {
        header("Location: index.php");
    }
    
