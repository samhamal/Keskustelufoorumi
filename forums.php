<?php 
    require_once "libs/common.php";
    require_once "models/user.php";
    require_once "models/forum.php";
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        $forums = Forum::get_all();
        view("forums", array("forums" => $forums));
    } else {
        header("Location: index.php");
    } 