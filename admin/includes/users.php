<?php
class User {
  // FUNCTION checked if key exists yet
   function checkKeys($tab, $randStr) {
     global $pdo;

     $query = $pdo->prepare("SELECT * FROM $tab");
     $query -> execute();
     $keyExists = false;
     while($row = $query->fetch(PDO::FETCH_ASSOC)) {
       if($row['keyAccess'] == $randStr) {
         $keyExists = true;
         break;
       } else {
         $keyExists = false;
       }
     }
     return $keyExists;
   }

   // FUNCTION unique key access for user
   function generateKey($tab) {
     $randStr = uniqid($tab);
     $checkKey = $this->checkKeys($tab, $randStr);

     while ($checkKey == true) {
       $randStr = uniqid($tab);
       $checkKey = $this->checkKeys($tab, $randStr);
     }

     return $randStr;
   }
   // update name for articles and events when user change profile
   public function update_author($old_author, $author, $tab) {
     global $pdo;
     $query = $pdo->prepare("UPDATE $tab SET author = ? WHERE author = ?");
     $query->bindValue(1, $author);
     $query->bindValue(2, $old_author);
     $query->execute();
   }
   //METHOD GET ALL USERS from users
   public function fetch_all_users() {
       global $pdo;

       $query = $pdo->prepare("SELECT * FROM users ORDER BY CAST(date_register AS DATE) DESC");
       $query -> execute();
       return $query->fetchAll(\PDO::FETCH_ASSOC);
   }
   // METHOD GET USER BY EMAIL ONLY
   public function get_user_talent_by_email($email, $tab) {
       global $pdo ;
       $query = $pdo->prepare("SELECT * FROM $tab WHERE email = ?");
       $query->bindValue(1, $email);
       $query->execute();
       $num = $query->rowCount();
       // print_r($query -> fetch(\PDO::FETCH_ASSOC));
       if($num ==1) {
         return $query -> fetch(\PDO::FETCH_ASSOC);
       } else {
         return json_encode(array('error' => "not-found"));
       }
   }

  //METHOD REGISTER USER
  public function register_user($email, $password, $lastname, $firstname, $genre, $phone) {
      global $pdo;

      $password = md5($password); // hach password
      $keyAccess = $this->generateKey('admin'); // key access user

      // first check the database to make sure
      // a user does not already exist with the same email
      $user_check_query = $pdo-> prepare("SELECT talents.email FROM talents WHERE email= ? UNION SELECT users.email FROM users WHERE users.email= ? AND users.type_profile = 'user'");

      $user_check_query->bindValue(1, $email);
      $user_check_query->bindValue(2, $email);

      $user_check_query->execute();
      $num = $user_check_query->rowCount();
      $user = $user_check_query->fetch();


      if ($num == 1) { // if user exists
          if ($user['email'] === $email) {
              $errorEmail = "Adresse mail existe déjà";
              return json_encode(array('error' => 'Adresse mail existe déjà'));
          }
      } else {
          $query = $pdo->prepare("INSERT INTO users(email, password, firstname, lastname , genre, phone, date_register, type_profile, keyAccess, profile_target) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $query->bindValue(1, $email);
          $query->bindValue(2, $password);
          $query->bindValue(3, $firstname);
          $query->bindValue(4, $lastname);
          $query->bindValue(5, $genre);
          $query->bindValue(6, $phone);
          $query->bindValue(7, $date_register);
          $query->bindValue(8, 'users');
          $query->bindValue(9, $keyAccess);
          $query->bindValue(10, 'images/user.png');
          $query->execute();

          $_SESSION['loggedAdmin'] = true;
          $_SESSION['email_ad'] = $email;
          $_SESSION['type_profile_admin'] = "users";
          header('location: index.php');
          exit();
      }
  }

  // METHOD LOGIN USER
  public function login_user($typeProfile, $email, $password) {
      global $pdo;

      // hach password for compare with db password
      $passwordHach = md5($password);

      $query = $pdo->prepare("SELECT * FROM $typeProfile where email = ? AND password = ?");
      $query->bindValue(1, $email);
      $query->bindValue(2, $passwordHach);

      $query->execute();
      $num = $query->rowCount();
      // if user exits or not
      if($num ==1) {
          $_SESSION['loggedAdmin'] = true;
          $_SESSION['email_ad'] = $email;
          $_SESSION['type_profile'] = $typeProfile;
          header('location: index.php');
          exit();
      } else {
          return json_encode(array('error' => "l'email ou le mot de passe est incorrect."));
      }
  }

  // METHOD UPDATE USER FROM USERS
  public function update_user($email, $lastname, $firstname, $genre, $phone, $target_file) {
    global $pdo;
    $user = $this->get_user_talent_by_email($email, 'users');

    if($user) {
      $old_author = $user['firstname'].' '.$user['lastname'];
      $author = $firstname.' '.$lastname;
      $query = $pdo->prepare("UPDATE users SET lastname=?, firstname=?, genre=?, phone=? , profile_target = ? WHERE email = ?");
      $query->bindValue(1, $lastname);
      $query->bindValue(2, $firstname);
      $query->bindValue(3, $genre);
      $query->bindValue(4, $phone);
      $query->bindValue(5, $target_file);
      $query->bindValue(6, $email);
      $query->execute();

      $this->update_author($old_author, $author, 'articles');
      $this->update_author($old_author, $author, 'events');
      $_SESSION['message_CB_admin'] = 'Votre profil à bien été mis a jour';
    } else {
      return json_encode(array('error' => "Nous n'avons pas pu mettre à jour votre profil. Merci de r&essayer ultérieurement"));
    }
  }



  //METHOD GET ALL USERS from talents
  public function fetch_all_models() {
      global $pdo;

      $query = $pdo->prepare("SELECT * FROM talents");
      $query -> execute();
      return $query->fetchAll(\PDO::FETCH_ASSOC);
  }
  //METHOD GET USER from talents
  public function get_models_by_keyAccess($id, $keyAccess) {
      global $pdo;

      $query = $pdo->prepare("SELECT * FROM talents WHERE id=? AND keyAccess =?");
      $query->bindValue(1, $id);
      $query->bindValue(2, $keyAccess);
      $query -> execute();
      $num = $query->rowCount();
      if($num == 1) {
        return $query->fetch(\PDO::FETCH_ASSOC);
      } else {
        return json_encode(array("error" => "Ce model n'exite pas dans notre base de données"));
      }
  }

}
?>
