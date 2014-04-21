<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/forum.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        $user = $_SESSION["current_user"];
        if($user->is_admin()) {
            
            if(isset($_GET["add"]) && isset($_POST["forum_title"])) {
                $title = filter_input(INPUT_POST, "forum_title", FILTER_SANITIZE_STRING);
                $id = filter_input(INPUT_POST, "forum_id", FILTER_SANITIZE_NUMBER_INT);
                $description = filter_input(INPUT_POST, "forum_desc", FILTER_SANITIZE_STRING);
                $forum = Forum::create($id, $title, $description);
                $forum->save();
                $forums = Forum::get_all();
                view("admin", array("forums" => $forums));
            }
            
            if(isset($_GET["edit"])) {
                if(isset($_GET["remove"])) {
                    $forum = Forum::get_by_id(parse_id("edit"));
                    $forum->delete();
                }
                
                if(isset($_POST["forum_title"])) {
                    $title = filter_input(INPUT_POST, "forum_title", FILTER_SANITIZE_STRING);
                    $id = filter_input(INPUT_POST, "forum_id", FILTER_SANITIZE_NUMBER_INT);
                    $description = filter_input(INPUT_POST, "forum_desc", FILTER_SANITIZE_STRING);
                    $forum = Forum::create($id, $title, $description);
                    $forum->update();
                    $forums = Forum::get_all();
                    view("admin", array("forums" => $forums));
                } else {
                    $target = Forum::get_by_id(parse_id("edit"));
                    $forums = Forum::get_all();
                    view("admin", array("target" => $target, "forums" => $forums));
                }
            } else {
                $forums = Forum::get_all();
                view("admin", array("forums" => $forums));
            }
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }