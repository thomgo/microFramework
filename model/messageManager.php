<?php

function getMessages($userId) {
  $db = getDataBase();
  $query = $db->prepare("SELECT m.*, u.pseudo FROM message AS m INNER JOIN users AS u ON m.sender = u.id WHERE getter = ?");
  $query->execute([$userId]);
  $result = $query->fetchall(PDO::FETCH_ASSOC);
  $query->closeCursor();
  return $result;
}

function addMessage($message, $sender) {
  $db = getDataBase();
  $query = $db->prepare("INSERT INTO message(content, date, sender, getter, object) VALUES (:content, NOW(), :sender, :getter, :object)");
  $result = $query->execute([
    "content" => $message["content"],
    "sender" => $sender,
    "getter" => $message["pseudo"],
    "object" => $message["object"]
  ]);
  $query->closeCursor();
  return $result;
}

 ?>
