<?php
    class Event {
        public function fetch_all() {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM events ORDER BY CAST(date_depart AS DATE) ASC");
            $query -> execute();
            return $query->fetchAll();
        }

        public function fetch_rand($num) {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM events ORDER BY RAND() LIMIT $num ");
            $query -> execute();
            return $query->fetchAll();
        }

        public function fetch_keyWord($key) {
            global $pdo;

            $key = "%$key%";

            $query = $pdo->prepare("SELECT * FROM events WHERE title LIKE ? || content LIKE ? || author LIKE ? || address LIKE ? || date_depart LIKE ? || hour_depart LIKE ? || date_end LIKE ? || hour_end LIKE ? ");
            $query->bindValue(1, $key);
            $query->bindValue(2, $key);
            $query->bindValue(3, $key);
            $query->bindValue(4, $key);
            $query->bindValue(5, $key);
            $query->bindValue(6, $key);
            $query->bindValue(7, $key);
            $query->bindValue(8, $key);
            $query -> execute();
            return $query->fetchAll();
        }

        public function fetch_data($id) {
            global $pdo;
            $query = $pdo->prepare("SELECT * FROM events WHERE id = ?");
            $query->bindValue(1, $id);
            $query->execute();
            $num = $query->rowCount();
            if($num ==1) {
              // print_r($query -> fetch(\PDO::FETCH_ASSOC));
              return $query -> fetch(\PDO::FETCH_ASSOC);
            } else {
              return json_encode(array('error' => "not-found"));
            }
        }

        // METHOD CREATE EVENT
        public function create_event($title, $address, $status, $date_depart, $hour_depart, $date_end, $hour_end, $content, $email) {
          global $pdo;

          // check the database to make sure a user does exist and had access
          $user_check_query = $pdo-> prepare("SELECT * FROM users WHERE email= ?");
          $user_check_query->bindValue(1, $email);

          $user_check_query->execute();
          $num = $user_check_query->rowCount();
          $user = $user_check_query->fetch();
          if ($num == 1) { // if user exists and had access
            $author = $user['firstname'].' '.$user['lastname'];
            $keyAccess = $user['keyAccess'];

            $query = $pdo->prepare("INSERT INTO events(title, address, date_depart, hour_depart, date_end, hour_end, content, keyAccess, author, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bindValue(1, $title);
            $query->bindValue(2, $address);
            $query->bindValue(3, $date_depart);
            $query->bindValue(4, $hour_depart);
            $query->bindValue(5, $date_end);
            $query->bindValue(6, $hour_end);
            $query->bindValue(7, $content);
            $query->bindValue(8, $keyAccess);
            $query->bindValue(9, $author);
            $query->bindValue(10, $status);
            $query->execute();

            $_SESSION['message_CB_admin'] = "Votre événement a été bien créé";
            header('location: events.php');
            exit();
          } else {
            return json_encode(array('error' => "Désolé une erreur s'est produite"));
          }
        }

        // METHOD EDIT event
        public function edit_event($title, $address, $status, $date_depart, $hour_depart, $date_end, $hour_end, $content, $author, $id) {
          global $pdo;

          // check author
          $user_check_query = $pdo-> prepare("SELECT events.author FROM events WHERE events.author = ? AND id = ?");

          $user_check_query->bindValue(1, $author);
          $user_check_query->bindValue(2, $id);
          $user_check_query->execute();
          $num = $user_check_query->rowCount();
          if ($num == 1) {
            $query = $pdo->prepare('UPDATE events SET title=?, address=?, date_depart=?, hour_depart=?, date_end=? , hour_end=? , content = ? , status= ? WHERE id=? AND author =?');
            $query->bindValue(1, $title);
            $query->bindValue(2, $address);
            $query->bindValue(3, $date_depart);
            $query->bindValue(4, $hour_depart);
            $query->bindValue(5, $date_end);
            $query->bindValue(6, $hour_end);
            $query->bindValue(7, $content);
            $query->bindValue(8, $status);
            $query->bindValue(9, $id);
            $query->bindValue(10, $author);
            $query->execute();
            $_SESSION['message_CB_admin'] = "Votre événement a été bien édité";
            header('location: events.php');
          } else {
            return json_encode(array('error' => "Vous n'êtes pas l'auteur de cet article, Vous ne pouvez pas donc l'éditer"));
          }
        }

        // METHOD DELETE artcile
        public function delete_event($id, $author) {
          global $pdo;
          // check author
          $user_check_query = $pdo-> prepare("SELECT events.author FROM events WHERE events.author = ? AND id = ?");

          $user_check_query->bindValue(1, $author);
          $user_check_query->bindValue(2, $id);
          $user_check_query->execute();
          $num = $user_check_query->rowCount();
          if ($num == 1) {
            $date_edit = strftime("%d %B %G");
            $query = $pdo->prepare('DELETE FROM events  WHERE id=? AND author =?');
            $query->bindValue(1, $id);
            $query->bindValue(2, $author);
            $query->execute();
            $_SESSION['message_CB_admin'] = "Votre événement a été bien supprimé";
            header('location: events.php');
            exit();
          } else {
            return json_encode(array('error' => "Vous n'êtes pas l'auteur de cet article, Vous ne pouvez pas donc l'éditer"));
          }
        }

    }
?>
