<?php

  function get_db_connection() {
    static $connection = null;

    if($connection == null) {
      $connection = new PDO('pgsql:');
      $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    return $connection;
  }
