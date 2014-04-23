<?php
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    if (isset($_SESSION["current_user"])) {
        // käyttäjä on jo kirjautunut, ohjataan etusivulle ettei rekisteröidy uudestaan
        header("Location: index.php");
    } else if (empty($_POST["username"]) || empty($_POST["password"])) {
        // käyttäjä ei ole kirjautunut äskettäin tai aikasemmin
        view("register");
    } else {
        // käyttäjä on rekisteröitymässä, tarkista syötteet
        if(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING) != filter_input(INPUT_POST, "password_confirm", FILTER_SANITIZE_STRING)) {
            error_password_match();
        } else if(strlen(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)) > 20) {
            error_username_too_long();
        } else {
            register();
        }
    }

    function error_username_too_long() {
        view("register", array(
                         "error" => "Käyttäjänimi voi olla enintään 20 merkkiä.",
                         "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                         "email" => filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
    }
    
    function error_password_match() {
        view("register", array(
                         "error" => "Salasanat eivät ole samat.",
                         "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                         "email" => filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
    }
    
    function error_cant_create_user() {
        view("register", array(
                         "error" => "Käyttäjän luominen ei onnistunut. Tarkista syöttämäsi tiedot.", 
                         "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                         "email" => filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
    }
    
    function register() {
        $user = User::create(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                             filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL), 
                             filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));

        if($user != null) {
            // tunnus luotu
            $_SESSION["current_user"] = $user;
            view("index-listing");
        } else {
            // rekisteröinnissä meni jotain pieleen
            error_cant_create_user();
        }
    }
