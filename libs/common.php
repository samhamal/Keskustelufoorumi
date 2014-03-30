<?php
    function view($page, $data = array()) {
        $data = (object)$data;
        require 'views/template.php';
        exit();
    }