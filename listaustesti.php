<?php
  $yhteys = new PDO("pgsql:");
  $yhteys->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $kysely = $yhteys->prepare("select * from käyttäjä");
  $kysely->execute();
  $taulu = $kysely->fetch();
  
  echo $taulu['käyttäjänimi'];
  
  $kysely = $yhteys->prepare("select * from aihealue");
  $kysely->execute();
  $taulu = $kysely->fetch();
  
  echo "<br>";
  echo $taulu['nimi'];
  echo "<br>";
  echo $taulu['kuvaus'];
