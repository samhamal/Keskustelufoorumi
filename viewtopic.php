<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    require_once "models/message.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        if(isset($_GET["id"])) {
            $messages = Message::get_messages_by_topic(parse_id("id"));
            $topic = $messages[0];
            $forum = Forum::get_by_id($topic->get_forum());
            $replies = array_splice($messages, 1); // poista viestiketjun aloitus viestilistasta
            $user = $_SESSION["current_user"];
            add_read($user->get_id(), $topic->get_id());
            view("viewtopic", array("forum" => $forum, "topic" => $topic, "replies" => $replies, "current_user" => $_SESSION["current_user"]));
            
        } else {
            header("Location: forums.php");
        }
    } else {
        header("Location: index.php");
    } 