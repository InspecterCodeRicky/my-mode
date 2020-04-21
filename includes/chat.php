<?php

class Chat {

  public function message_contact($from, $name, $subject, $message) {
    global $pdo;

    $date_send = date('Y-m-d h:i');
    $query = $pdo->prepare("INSERT INTO messages(email, name, subject, message, date_send) VALUES(?, ?, ?, ?, ?)");
    $query->bindValue(1, $from);
    $query->bindValue(2, $name);
    $query->bindValue(3, $subject);
    $query->bindValue(4, $message);
    $query->bindValue(5, $date_send);

    $query->execute();

    $row = $query->rowCount();
    if($row == 1) {
      $_SESSION['message_CB'] = 'Votre message a bien été envoyé.';
      header('location: contact.php');
      exit();
    } else {
      return json_encode(array('error' => "nous avon rencontré un problème, veuillez réessaiyer."));
    }
  }

  public function isJSON($string){
     return is_string($string) && is_array(json_decode($string, true)) ? true : false;
  }
}





?>
