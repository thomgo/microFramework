<?php
  function welcome() {
    redirectTo("param", ["id" => "5", "name" => "thomas", "istrue" => "0"]);
    $message = "Bonjour voici un boilerplate PHP intégrant un système de routing";
    require "view/exempleView.php";
  }

  function param() {
    echo "olé";
    var_dump($_GET);
  }

 ?>
