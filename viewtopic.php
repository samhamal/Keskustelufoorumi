<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    // todo: hae tietty viestiketju
    if(isset($_GET["id"])) {
        
    }
    
    if(isset($_SESSION["current_user"])) {
        view("viewtopic");
    } else {
        header("Location: index.php");
    } 