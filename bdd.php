<?php

function bdd() {
    try {
      $bdd = new PDO("mysql:dbname=cv; host=127.0.0.1; charset=utf8", "root", "aze123!321EZA");
    } catch (PDOException $e) {
      echo 'Echec lors de la connexion : ' . $e->getMessage();
    }
    return $bdd;
  }

?>
