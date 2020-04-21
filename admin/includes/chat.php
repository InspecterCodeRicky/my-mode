<?php

  class Chat {

    public function fetchAll_message() {
      global $pdo;

      $query = $pdo->prepare("SELECT * FROM messages  ORDER BY CAST(date_send AS DATE) DESC");
      $query -> execute();
      return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
  }



?>
