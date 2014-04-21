<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    require_once "models/message.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        if(isset($_GET["topic"]) && isset($_GET["edit"]) && isset($_POST["message"])) {
            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
            $target = Message::get_by_id(parse_id("edit"));
            $user = $_SESSION["current_user"];
            
            // Vain käyttäjä itse voi muokata omia viestejään
            if ($user->get_id() == $target->get_owner()->get_id()) {
                $target->set_body($message);
                $target->save();
                header("Location: viewtopic.php?id=" . parse_id("topic"));
            }
        }
        
        if(isset($_GET["topic"]) && isset($_GET["edit"])) {
            $topic = Message::get_by_id(parse_id("topic"));
            $target = Message::get_by_id(parse_id("edit"));
            if($topic && $target) {
                $user = $_SESSION["current_user"];
                
                view("editmessage", array("target" => $target, "current_user" => $_SESSION["current_user"], "topic" => $topic));
            } else {
                // Käyttäjä mennyt itse muuttamaan osoiterivin GET parametreja
                view("forums", array("error" => "Virhe viestin muokkauksessa."));
            }
        } else {
            header("Location: forums.php");
        }
    } else {
        header("Location: index.php");
    } 