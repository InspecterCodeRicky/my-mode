<?php
    class Article {
        public function fetch_all() {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM articles ORDER BY CAST(date_create AS DATE) DESC");
            $query -> execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function fetch_rand() {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM articles ORDER BY RAND() LIMIT 3 ");
            $query -> execute();
            return $query->fetchAll();
        }

        public function fetch_keyWord($key) {
            global $pdo;

            $key = "%$key%";

            $query = $pdo->prepare("SELECT * FROM articles WHERE title LIKE ? || content LIKE ? || category LIKE ? || author LIKE ? || date_create LIKE ?");
            $query->bindValue(1, $key);
            $query->bindValue(2, $key);
            $query->bindValue(3, $key);
            $query->bindValue(4, $key);
            $query->bindValue(5, $key);
            $query -> execute();
            return $query->fetchAll();
        }

        public function fetch_data($id) {
            global $pdo;
            $query = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
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


        public function create_article($target_file, $title, $content, $tagname, $status, $email, $keyAccess) {
          global $pdo;

          // check the database to make sure a user does exist and had access
          $user_check_query = $pdo-> prepare("SELECT * FROM users WHERE email= ? AND keyAccess = ?");

          $user_check_query->bindValue(1, $email);
          $user_check_query->bindValue(2, $keyAccess);

          $user_check_query->execute();
          $num = $user_check_query->rowCount();
          $user = $user_check_query->fetch();
          $author = $user['firstname'].' '.$user['lastname'];
          $date_create = strftime("%G-%m-%d");
          if ($num == 1) { // if user exists and had access
            $query = $pdo->prepare("INSERT INTO articles(title, content, target_file, author, date_create, category, status, keyAccess) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, $target_file);
            $query->bindValue(4, $author);
            $query->bindValue(5, $date_create);
            $query->bindValue(6, $tagname);
            $query->bindValue(7, $status);
            $query->bindValue(8, $keyAccess);
            $query->execute();

            $_SESSION['message_CB_admin'] = "Votre article a été bien créé";
            header('location: conseils.php');
            exit();
          } else {
            return json_encode(array('error' => 'pas bon'));
          }
        }

        // METHOD EDIT artcile
        public function edit_article($id, $target_file, $title, $content, $tagname, $status, $author) {
          global $pdo;

          // check author
          $user_check_query = $pdo-> prepare("SELECT articles.author FROM articles WHERE articles.author = ? AND id = ?");

          $user_check_query->bindValue(1, $author);
          $user_check_query->bindValue(2, $id);
          $user_check_query->execute();
          $num = $user_check_query->rowCount();
          if ($num == 1) {
            $date_edit = strftime("%G-%m-%d");
            $query = $pdo->prepare('UPDATE articles SET title=?, content=?, target_file=?, category=?, status=?, date_edit = ? WHERE id=? AND author =?');
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, $target_file);
            $query->bindValue(4, $tagname);
            $query->bindValue(5, $status);
            $query->bindValue(6, $date_edit);
            $query->bindValue(7, $id);
            $query->bindValue(8, $author);
            $query->execute();
            $_SESSION['message_CB_admin'] = "Votre article a été bien édité";

          } else {
            return json_encode(array('error' => "Vous n'êtes pas l'auteur de cet article, Vous ne pouvez pas donc l'éditer"));
          }
        }

        // METHOD DELETE artcile
        public function delete_article($id, $author) {
          global $pdo;
          // check author
          $user_check_query = $pdo-> prepare("SELECT articles.author FROM articles WHERE articles.author = ? AND id = ?");

          $user_check_query->bindValue(1, $author);
          $user_check_query->bindValue(2, $id);
          $user_check_query->execute();
          $num = $user_check_query->rowCount();
          if ($num == 1) {
            $date_edit = strftime("%G-%m-%d");
            $query = $pdo->prepare('DELETE FROM articles  WHERE id=? AND author =?');
            $query->bindValue(1, $id);
            $query->bindValue(2, $author);
            $query->execute();
            $_SESSION['message_CB_admin'] = "Votre article a été bien supprimé";
            header('location: conseils.php');
            exit();
          } else {
            return json_encode(array('error' => "Vous n'êtes pas l'auteur de cet article, Vous ne pouvez pas donc l'éditer"));
          }
        }

    }
?>
