<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/message.php";
    require "models/forum.php";
    session_start();
    
    if (isset($_SESSION["current_user"])) {
        if (!isset($_POST["user_username"]) && isset($_GET["user"])) {
            initial_user_listing();
        } else if (isset($_GET["topic"]) && !isset($_POST["topic_username"]) && !isset($_POST["topic_name"])) {
            initial_topic_listing();
        } else if (isset($_POST["user_username"])) {
            search_users();
        } else if (isset($_POST["topic_title"]) && !empty($_POST["topic_title"])) {
            search_topic_by_title();
        } else if (isset($_POST["topic_username"]) && !empty($_POST["topic_username"])) {
            search_topic_by_username();
        } else if (isset($_POST["topic_forum"]) && !empty($_POST["topic_forum"])) {
            search_topic_by_forum();
        }
    } else {
        header("Location: index.php");
    }
    
    function initial_topic_listing() {
        $topics = Message::get_all_topics();
        view("find", array("find_topic" => true, "topics" => $topics, "forums" => Forum::get_all_as_array()));
        exit();
    }
    
    function search_topic_by_forum() {
        $forum = filter_input(INPUT_POST, "topic_forum", FILTER_SANITIZE_STRING);
        $topics = Message::get_topics_by_forum_id($forum);
        view("find", array("find_topic" => true, "topics" => $topics, "forums" => Forum::get_all_as_array()));
        exit();
    }
    
    function search_topic_by_username() {
        $username = filter_input(INPUT_POST, "topic_username", FILTER_SANITIZE_STRING);
        $topics = Message::search_topic_by_sender($username);
        view("find", array("find_topic" => true, "topics" => $topics, "forums" => Forum::get_all_as_array()));
        exit();
    }
    
    function search_topic_by_title() {
        $title = filter_input(INPUT_POST, "topic_title", FILTER_SANITIZE_STRING);
        $title = "%" . $title . "%";
        $topics = Message::search_topic_by_title($title);
        view("find", array("find_topic" => true, "topics" => $topics, "forums" => Forum::get_all_as_array()));
    }
    
    function initial_user_listing() {
        $user_array = User::find_many("%");
        view("find", array("find_user" => true, "users" => $user_array));
        exit();
    }
    
    function search_users() {
        if(empty($_POST["user_username"])) {
            initial_user_listing();
        } else {
            $user_array = User::find_many("%" . filter_input(INPUT_POST, "user_username", FILTER_SANITIZE_STRING) . "%");
            view("find", array("find_user" => true, "users" => $user_array));
            exit();
        }
    }