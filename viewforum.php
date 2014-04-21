<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/forum.php";
    require "models/message.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        if(isset($_GET["id"])) {
            $forum = Forum::get_by_id(parse_id("id"));
            $topics = Message::get_topics_by_forum_id($forum->get_id());
            
            view("viewforum", array("forum" => $forum, "topics" => $topics, "current_user" => $_SESSION["current_user"]));
            
        } else {
            header("Location: forums.php");
        }
    } else {
        header("Location: index.php");
    } 