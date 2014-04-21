<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    require_once "models/message.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        if(isset($_GET["topic"]) && isset($_GET["parent"])) {
            $topic = Message::get_by_id(parse_id("topic"));
            $parent = Message::get_by_id(parse_id("parent"));
            if($topic && $parent) {
                $reply = filter_input(INPUT_POST, "reply", FILTER_SANITIZE_STRING);
                $user = $_SESSION["current_user"];
                Message::create($reply, $parent, $parent->get_forum(), $user->get_id(), null);
                
                header("Location: viewtopic.php?id=" . $topic->get_id());
            } else {
                // Käyttäjä mennyt itse muuttamaan osoiterivin GET parametreja
                view("forums", array("error" => "Virhe viestin lähetyksessä."));
            }
        } else {
            header("Location: forums.php");
        }
    } else {
        header("Location: index.php");
    } 