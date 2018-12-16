<?php
//Fichier basique pour gérer les différentes sources, action et autres redirection

function addParameters($action, $parameters) {
  $action .= "?";
  //Si les paramètre son définis, on les ajoute à la route
  foreach ($parameters as $key => $value) {
    $action .= $key ."=" . $value;
    if($value !== end($parameters)) {
      $action .= "&";
    }
  }
  return $action;
}


function makeAction($target, $parameters = false) {
  $config = getGlobalConfig();
  $action = "http://" . $config["host"] . $target;
  if($parameters) {
    $action  = addParameters($action, $parameters);
  }
  return $action;
}

//Function pour indiquer l'action du formulaire vers une l'url absolue
// $target est la route de destion, $parameters (optionnel) attend un tableau associatif avec les éventuels paramètres de la route
// exemple : setAction(user/new) ou setAction(user/modify, ["id" => 4])
function setAction($target, $parameters = false) {
  $action = makeAction($target, $parameters);
  echo "action='$action'";
}

//Function pour indiquer la cible d'un lien via un href, fonctionnement similaire à setAction
function setHref($target, $parameters = false) {
  $action = makeAction($target, $parameters);
  echo "href='$action'";
}

//redirection based on absolute url
function redirectTo($target, $parameters = false) {
  $url = makeAction($target, $parameters);
  header("Location: " . $url);
  exit;
}
 ?>
