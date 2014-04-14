<?php 
    require "libs/common.php";
    require "models/user.php";
    require "models/forum.php";
    
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        $user = $_SESSION["current_user"];
        if($user->is_admin()) {
            $forums = Forum::get_all();
            view("admin", array("forums" => $forums));
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }