<?php
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    // kirjaudu ulos
    if(isset($_GET["logout"])) {
        session_unset();
        session_destroy();
    }
    
    if (isset($_SESSION["current_user"])) {
    // käyttäjä kirjautunut joskus aikasemmin. hae viimesimmät lukemattomat viestit ja näytä listaus
        view("index-listing");
    } else if (empty($_POST["username"]) || empty($_POST["password"])) {
        // käyttäjä ei ole kirjautunut äskettäin tai aikasemmin
        view("index-login");
    } else {
        // käyttäjä on kirjautumassa
        $user = User::find_user(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
        if($user != null) {
            // oikeat tunnukset annettu, näytetään listaus viimeisimmistä viesteistä
            $_SESSION["current_user"] = $user;
            view("index-listing");
        } else {
            // väärät tunnukset annettu
            view("index-login", array("error" => "Väärä käyttäjätunnus tai salasana.", "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)));
        }
    }

