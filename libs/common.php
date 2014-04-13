<?php
    function view($page, $data = array()) {
        $data = (object)$data;
        require 'views/template.php';
        exit();
    }
    
    date_default_timezone_set("Europe/Helsinki");
    