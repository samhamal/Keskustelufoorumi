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
        // käyttäjä on rekisteröitymässä
        if(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING) != filter_input(INPUT_POST, "password_confirm", FILTER_SANITIZE_STRING)) {
            view("register", array(
                             "error" => "Salasanat eivät ole samat.",
                             "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                             "email" => filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
        } else {
            $user = User::create(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                                 filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL), 
                                 filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));

            if($user != null) {
                // tunnus luotu
                $_SESSION["current_user"] = $user;
                view("index-listing");
            } else {
                // rekisteröinnissä meni jotain pieleen
                view("register", array(
                                 "error" => "Jotain meni pieleen. Tarkista syöttämäsi tiedot.", 
                                 "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                                 "email" => filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)));
            }
        }
    }

