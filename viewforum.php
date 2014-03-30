<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    // todo: hae tietty keskustelualue
    if(isset($_GET["id"])) {
        
    }
    
    if(isset($_SESSION["current_user"])) {
        view("viewforum");
    } else {
        header("Location: index.php");
    } 