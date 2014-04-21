<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    require_once "models/message.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        $user = $_SESSION["current_user"];
        
        if(isset($_GET["topic"]) && isset($_GET["edit"]) && isset($_GET["remove"])) {
            remove_message();
        }
        
        if(isset($_GET["topic"]) && isset($_GET["edit"]) && isset($_POST["message"])) {
            save_edited_message();
        }
        
        if(isset($_GET["topic"]) && isset($_GET["edit"])) {
            show_editable_message();
        } else {
            header("Location: forums.php");
        }
    } else {
        header("Location: index.php");
    } 
    
    function remove_message() {
        $user = $_SESSION["current_user"];
        $target = Message::get_by_id(parse_id("edit"));

        if($user->get_id() == $target->get_owner()->get_id() || $user->is_admin()) {
            $target->remove(false);
        }

        if($target->get_parent() == null) {
            header("Location: viewforum.php?id=" . $target->get_forum());
        } else {
            header("Location: viewtopic.php?id=" . parse_id("topic"));
        }
        exit();
    }
    
    function save_edited_message() {
        $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
        $target = Message::get_by_id(parse_id("edit"));
        $user = $_SESSION["current_user"];

        // Vain käyttäjä itse voi muokata omia viestejään
        if ($user->get_id() == $target->get_owner()->get_id()) {
            $target->set_body($message);
            $target->save();
            header("Location: viewtopic.php?id=" . parse_id("topic"));
        } else {
            header("Location: viewtopic.php?id=" . parse_id("topic"));
        }
        exit();
    }
    
    function show_editable_message() {
        $topic = Message::get_by_id(parse_id("topic"));
        $target = Message::get_by_id(parse_id("edit"));
        if($topic && $target) {
            view("editmessage", array("target" => $target, "topic" => $topic));
        } else {
            // Käyttäjä mennyt itse muuttamaan osoiterivin GET parametreja
            header("Location: forums.php");
        }
        exit();
    }