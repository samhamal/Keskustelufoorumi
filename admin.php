<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    // todo: hae tietty keskustelualue
    if(isset($_GET["id"])) {
        
    }
    
    if(isset($_SESSION["current_user"])) {
        $user = $_SESSION["current_user"];
        if($user->is_admin()) {
            view("admin");
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }