<?php

//Function qui retourne un tableau contenant les routes de notre application

//Modèle des routes
//"NomDeLaRoute" => [
//  "Controller",
//  "Fonction",
//  Optionnel [
//    "parametre1" => ["typeAttendu", optionnel[valeurAttendu]],
//    "parametre2" => ["typeAttendu", optionnel[valeurAttendu]]
//  ]
// "status" => "role"
//]
function getRoutes() {
  return [
    "" => [
      "exemple",
      "welcome"
    ],
    "param" => [
      "exemple",
      "param",
      [
        "id" => ["integer"],
        "name" => ["string"],
        "istrue" => ["boolean"]
      ]
    ],
    "login" => [
      "admin",
      "loginUser"
    ]
  ];
}

 ?>
