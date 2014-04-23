<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/forum.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        $user = $_SESSION["current_user"];
        if($user->is_admin()) {
            
            if(isset($_GET["add"]) && isset($_POST["forum_title"])) {
                add_forum();
            }
            
            if(isset($_GET["edit"])) {
                if(isset($_GET["remove"])) {
                    $forum = Forum::get_by_id(parse_id("edit"));
                    $forum->delete();
                }
                
                if(isset($_POST["forum_title"])) {
                    edit_forum_save();
                } else {
                    edit_forum_view();
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
    
    function add_forum() {
        $forums = Forum::get_all();
        $forumarray = Forum::get_all_as_array();
        $title = filter_input(INPUT_POST, "forum_title", FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, "forum_id", FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, "forum_desc", FILTER_SANITIZE_STRING);
        
        if($forumarray[$id] == null) {
            $forum = Forum::create($id, $title, $description);
            $forum->save();
            view("admin", array("forums" => $forums));
        } else {
            view("admin", array("forums" => $forums, "error" => "Annettu id ei ole uniikki.", "title" => $title, "description" => $description));
        }
    }
    
    function edit_forum_save() {
        $title = filter_input(INPUT_POST, "forum_title", FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, "forum_id", FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, "forum_desc", FILTER_SANITIZE_STRING);
        $forum = Forum::create($id, $title, $description);
        $forum->update(parse_id("edit"));
        $forums = Forum::get_all();
        view("admin", array("forums" => $forums));
    }
    
    function edit_forum_view() {
        $target = Forum::get_by_id(parse_id("edit"));
        $forums = Forum::get_all();
        view("admin", array("target" => $target, "forums" => $forums));        
    }