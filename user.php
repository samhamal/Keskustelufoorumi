<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    // todo: hae toisen käyttäjän tiedot
    if(isset($_GET["id"])) {
        
    }
    
    if(isset($_SESSION["current_user"])) {
        view("user", array("user" => $_SESSION["current_user"]));
    } else {
        header("Location: index.php");
    } 