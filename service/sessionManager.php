<?php

//Fonction de démarrage d'une session anonyme 
function initializeAnonymousSession($answers) {
  session_start();
  $_SESSION["user"] = "anonymous";
}

//Fonction de démarrage standard d'une session utilisateur
function initializeUserSession($user) {
  session_start();
  $_SESSION["user"] = $user;
}

//Fonction de déconnexion
function logout() {
  session_start();
  session_unset();
  session_destroy();
}

//Fonction pour vérifier qu'un utilisateur est connecté
function isLogged() {
  if(isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
    return true;
  }
  return false;
}

 ?>
