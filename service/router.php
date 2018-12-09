<?php
require "config/routes.php";

//On récupère la requête, si rien n'a été passé à l'url on met une requête vide
//On enlève les éventuelles extension au cas où l'utilisateur tape l'url à la main
function getCurrentRequest() {
  if(isset($_GET["path"])) {
    $request = str_replace([".php", ".html"],"",htmlspecialchars($_GET["path"]));
  }
  else {
    $request = "";
  }
  return $request;
}

//Fonction pour vérifier qu'un utilisateur a le bon satut pour la route
function checkUserCredential($route) {
  session_start();
  $config = getGlobalConfig();
  if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["status"])) {
    redirectTo($config["defaultRoute"]);
  }
  $roles = $config["status"];
  $userRole = $_SESSION["user"]["status"];
  if(!in_array($userRole, $roles) || (array_search($userRole, $roles) < array_search($route["status"], $roles))) {
    redirectTo($config["defaultRoute"]);
  }
}

//Function qui vérifie l'adéquation de la valeur du paramètre avec les spécifications de la route
function checkParameterValidity($specification, $parameterValue) {
  //Si on détecte des balises
  if($parameterValue !== htmlspecialchars($parameterValue)) {
    return false;
  }
  //Si on attend un boolean
  if($specification[0] ==="boolean" && !preg_match("#^[0-1]+$#", $parameterValue)) {
    return false;
  }
  //Si on attend un integer
  if($specification[0] ==="integer" && !preg_match("#^[0-9]+$#", $parameterValue)) {
    return false;
  }
  //Si on attend une string, on vérifie la présence d'au moins une lettre
  if($specification[0] ==="string" && !preg_match("#(?=.*?[A-Za-z]).+#", $parameterValue)) {
    return false;
  }

  //Si on a défini des valeurs attendus on vérifie la correspondance
  if(isset($specification[1])) {
    if(!in_array($parameterValue, $specification[1])){
      return false;
    }
  }
  return true;
}

//Fonction pour vérifier l'adéquation des paramètres avec ce qui est spécifié dans le fichier de routing
function checkRequestParameters($route) {
  //Si la route attend un type d'utilisateur particulier
  if(isset($route["status"])) {
    checkUserCredential($route);
  }
  //Si on a passé des paramètres alors que la route ne l'attendais pas
  if(count($_GET)>1 && !isset($route[2])) {
    return false;
  }
  //Si on a des paramètres
  if(isset($route[2])) {
    //On vérifie le bon nombre de paramètres moins le paramètre path
    $parameters = $route[2];
    if((count($_GET)-1) !== count($parameters)) {
      return false;
    }
    //On parcours les paramètres pour vérifier qu'ils existent dans le routing et ne sont pas vides
    foreach ($_GET as $key => $value) {
      if($key !== "path") {
        //On vérifie que le paramètre de GET existe et contient une valeur
        if(!isset($parameters[$key]) || empty($value)) {
          return false;
        }
        //On vérifie la validité de la valeur avec les spécifications attendues
        if(!checkParameterValidity($parameters[$key], $value)) {
          return false;
        }
      }
    }
  }
  return true;
}

//Fonction appelle la bonne fonction du controleur ou une page d'erreur
function route() {
  $request = getCurrentRequest();
  $routes = getRoutes();

    //Si la page demandée match une route définie
    if(isset($routes[$request])) {
      $route = $routes[$request];
      //On vérifie la validité des paramètres
      if(!checkRequestParameters($route)) {
        require "404.html";
        return;
      }
      //On charge le controller concerné et on appelle la fonction définies dans la configuration
      require "controller/" . $route[0] . "Controller.php";
      $route[1]();
      return;
    }
    else {
      //Si on a trouvé aucune route on affiche la page d'erreur standard du boilerplate
      require "404.html";
      return;
    }
}

 ?>
