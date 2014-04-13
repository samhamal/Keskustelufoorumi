<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    require_once "models/message.php";
    
    session_start();
    
    function parse_id($param) {
        if (empty($_GET[$param])) {
            return 0;
        } else {
            return filter_input(INPUT_GET, $param, FILTER_SANITIZE_NUMBER_INT);
        }
    }

    if(isset($_SESSION["current_user"])) {
        if(isset($_GET["topic"]) && isset($_GET["remove"])) {
            $topic = Message::get_by_id(parse_id("topic"));
            $target = Message::get_by_id(parse_id("remove"));
            if($topic && $target) {
                $target->remove();
                header("Location: viewtopic.php?id=" . $topic->get_id());
            } else {
                // Käyttäjä mennyt itse muuttamaan osoiterivin GET parametreja?
                view("forums", array("error" => "Virhe viestin poistamisessa."));
            }
        } else {
            header("Location: forums.php");
        }
    } else {
        header("Location: index.php");
    } 