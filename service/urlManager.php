<?php
//Fichier basique pour gérer les différentes sources, action et autres redirection

//Function pour indiquer l'action du formulaire vers une l'url absolue
// $target est la route de destion, $parameters (optionnel) attend un tableau associatif avec les éventuels paramètres de la route
// exemple : setAction(user/new) ou setAction(user/modify, ["id" => 4])
function setAction($target, $parameters = false) {
  $config = getGlobalConfig();
  $action = "http://" . $config["host"] . $target;
  if($parameters) {
    $action .= "?";
    //Si les paramètre son définis, on les ajoute à la route
    foreach ($parameters as $key => $value) {
      $action .= $key ."=" . $value;
      if(isset($parameters[$key + 1])) {
        $action .= "&&";
      }
    }
  }
  echo "action='$action'";
}

function setHref($target, $parameters = false) {
  $config = getGlobalConfig();
  $action = "http://" . $config["host"] . $target;
  if($parameters) {
    $action .= "?";
    //Si les paramètre son définis, on les ajoute à la route
    foreach ($parameters as $key => $value) {
      $action .= $key ."=" . $value;
      if(isset($parameters[$key + 1])) {
        $action .= "&&";
      }
    }
  }
  echo "href='$action'";
}

//redirection based on absolute url
function redirectTo($target) {
  $config = getGlobalConfig();
  $url = "http://" . $config["host"] . $target;
  header("Location: " . $url);
  exit;
}
 ?>
