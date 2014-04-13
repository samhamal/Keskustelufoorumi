<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/message.php";
    session_start();
    
    if (isset($_SESSION["current_user"])) {
        if (!isset($_POST["user_username"]) && isset($_GET["user"])) {
            $user_array = User::find_many("%");
            view("find", array("find_user" => true, "users" => $user_array));
        } else if (isset($_GET["topic"]) && !isset($_POST["topic_username"]) && !isset($_POST["topic_name"])) {
            view("find", array("find_topic" => true, "topics" => null));
        } else if (isset($_POST["user_username"])) {
            if(empty($_POST["user_username"])) {
                $user_array = User::find_many("%");
            } else {
                $user_array = User::find_many("%" . filter_input(INPUT_POST, "user_username", FILTER_SANITIZE_STRING) . "%");
            }
            view("find", array("find_user" => true, "users" => $user_array));
        } else if (isset($_POST["topic_username"])) {
            $user = User::find_one(filter_input(INPUT_POST, "topic_username", FILTER_SANITIZE_STRING));
            $topics = Message::get_by_user_id($user->get_id());
            view("find", array("find_topic" => true, "topics" => $topics));
        }

    } else {
        header("Location: index.php");
    } 