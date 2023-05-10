<?php

    session_start();

    // destruction de la variable de session
    session_unset();
    
    $_SESSION = array();

    // destruction de la session
    session_destroy();
    // Redirection vers la page d'accueil
    header('location: https://club-vosgien-mulhouse.fr/');

    exit;

?>