<?php 
    require "libs/common.php";
    require "models/user.php";
    session_start();
    
    if(isset($_SESSION["current_user"])) {
        view("find");
    } else {
        header("Location: index.php");
    } 