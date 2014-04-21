<?php
    require "libs/common.php";
    require "models/user.php";
    require "models/message.php";
    require "models/forum.php";
    session_start();
    
    // kirjaudu ulos
    if(isset($_GET["logout"])) {
        session_unset();
        session_destroy();
    }
    
    if (isset($_SESSION["current_user"])) {
        // käyttäjä kirjautunut joskus aikasemmin. hae viimesimmät lukemattomat viestit ja näytä listaus
        $user = $_SESSION["current_user"];
        $topics = Message::get_latest_topics(5);
        $unread = Message::get_unread_posts($user->get_id());
        $forums = Forum::get_all();
        
        $forumarray = array();
        foreach($forums as $forum) {
            $forumarray[$forum->get_id()] = $forum->get_name();
        }
        view("index-listing", array("topics" => $topics, "unread" => $unread, "forums" => $forumarray));
    } else if (empty($_POST["username"]) || empty($_POST["password"])) {
        // käyttäjä ei ole kirjautunut äskettäin tai aikasemmin
        view("index-login");
    } else {
        // käyttäjä on kirjautumassa
        $user = User::login(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING), 
                           filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
        if($user != null) {
            // oikeat tunnukset annettu, näytetään listaus viimeisimmistä viesteistä
            $_SESSION["current_user"] = $user;
            $topics = Message::get_latest_topics(5);
            $unread = Message::get_unread_posts($user->get_id());
            view("index-listing", array("topics" => $topics, "unread" => $unread, "forums" => $forumarray));
        } else {
            // väärät tunnukset annettu
            view("index-login", array(
                                "error" => "Väärä käyttäjätunnus tai salasana.", 
                                "username" => filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING)));
        }
    }

