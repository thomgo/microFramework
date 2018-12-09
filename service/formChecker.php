<?php
//Function qui nettoie les entrées d'un formulaire
function clearForm($form) {
  foreach ($form as $key => $value) {
    $form[$key] = htmlspecialchars($value);
  }
  return $form;
}

//Function qui vérifie si un champ est vide
function isFieldEmpty($form) {
  foreach ($form as $key => $value) {
    if(empty($value)) {
      return true;
    }
  }
  return false;
}

//Function qui vérifie si un champ est trop court
function isTooShort($value, $length) {
  if(strlen($value) < $length) {
    return true;
  }
  return false;
}


 ?>
