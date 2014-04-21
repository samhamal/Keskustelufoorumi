<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    require_once "models/message.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        if(isset($_POST["forum"]) && isset($_POST["message"]) && isset($_POST["title"])) {
            $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
            $forum = filter_input(INPUT_POST, "forum", FILTER_SANITIZE_STRING);
            $user = $_SESSION["current_user"];
            
            $topic = Message::create($message, null, $forum, $user->get_id(), $title);
            header("Location: viewtopic.php?id=" . $topic->get_id());
        } else {
            $forums = Forum::get_all();
            view("new_topic", array("user" => $_SESSION["current_user"], "forums" => $forums));
        }
    } else {
        header("Location: index.php");
    } 