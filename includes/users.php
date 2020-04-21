<?php
    class User {
        // FUNCTION checked if key exists yet
         function checkKeys($tab, $randStr) {
           global $pdo;

           $query = $pdo->prepare("SELECT * FROM $tab ORDER BY RAND()");
           $query -> execute();

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

        //METHOD GET ALL USERS
        public function fetch_all_users($tab) {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM $tab");
            $query -> execute();
            return $query->fetchAll();
        }

        // METHOD GET USERS BY LIMIT
        public function fetch_rand_limit_user($limit, $tab) {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM $tab ORDER BY RAND() LIMIT $limit ");
            $query -> execute();
            return $query->fetchAll();
        }

        public function fetch_search_user($key) {
            global $pdo;

            $key = "%$key%";

            $query = $pdo->prepare("SELECT * FROM talent WHERE type_profil = 'talent' AND title LIKE ? || content LIKE ? || category LIKE ? || author LIKE ? || date LIKE ?");
            $query->bindValue(1, $key);
            $query->bindValue(2, $key);
            $query->bindValue(3, $key);
            $query->bindValue(4, $key);
            $query->bindValue(5, $key);
            $query -> execute();
            return $query->fetchAll();
        }
        // METHOD GET USER BY ID ONLY
        public function get_user_by_id($id, $tab) {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM $tab WHERE id = ?");
            $query->bindValue(1, $id);
            $query->execute();
            return $query -> fetch();
        }
        // METHOD GET USER BY EMAIL ONLY
        public function get_user_talent_by_email($email, $tab) {
            global $pdo ;

            $query = $pdo->prepare("SELECT * FROM $tab WHERE email = ?");
            $query->bindValue(1, $email);
            $query->execute();
            $num = $query->rowCount();
            if($num ==1) {
              // print_r($query -> fetch(\PDO::FETCH_ASSOC));
              return $query -> fetch(\PDO::FETCH_ASSOC);
            } else {
              return json_encode(array('error' => "not-found"));
            }
        }
        // METHOD GET USER BY EMAIL ONLY
        public function get_user_talent_by_keyAccess($id,$keyAccess, $tab) {
            global $pdo ;

            $query = $pdo->prepare("SELECT * FROM $tab WHERE id = ? AND keyAccess = ?");
            $query->bindValue(1, $id);
            $query->bindValue(2, $keyAccess);
            $query->execute();
            $num = $query->rowCount();
            if($num ==1) {
              return $query -> fetch(\PDO::FETCH_ASSOC);
            } else {
              return json_encode(array('error' => "not-found"));
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
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['type_profile'] = $typeProfile;
                header('location: talents.php');
                exit();
            } else {
                return json_encode(array('error' => "l'email ou le mot de passe est incorrect ou votre type de profile n'est pas le bon"));
            }
        }
        // METHOD REGISTER MODEL
        public function register_model($email, $password, $lastname, $firstname, $genre, $birthday, $phone, $target_file) {
            global $pdo;

            $password = md5($password); // hach password
            $keyAccess = $this->generateKey('talents'); // key access user

            setlocale(LC_TIME, 'fr_FR.utf8','fra');
            $date_register = strftime("%d %B %G");
            // first check the database to make sure
            // a user does not already exist with the same email
            $user_check_query = $pdo-> prepare("SELECT talents.email FROM talents WHERE email= ? UNION SELECT users.email FROM users WHERE users.email= ? AND users.type_profile = 'users'");

            $user_check_query->bindValue(1, $email);
            $user_check_query->bindValue(2, $email);

            $user_check_query->execute();
            $num = $user_check_query->rowCount();
            $user = $user_check_query->fetch();


            if ($num == 1) { // if user exists
                if ($user['email'] === $email) {
                    return json_encode(array('error' => 'Adresse mail existe déjà'));
                }
            } else {
                $query = $pdo->prepare("INSERT INTO talents(email, password, firstname, lastname , genre, birthday, phone, date_register, photos, keyAccess) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $query->bindValue(1, $email);
                $query->bindValue(2, $password);
                $query->bindValue(3, $firstname);
                $query->bindValue(4, $lastname);
                $query->bindValue(5, $genre);
                $query->bindValue(6, $birthday);
                $query->bindValue(7, $phone);
                $query->bindValue(8, $date_register);
                $query->bindValue(9, $target_file);
                $query->bindValue(10, $keyAccess);
                $query->execute();

                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['type_profile'] = "talents";
                header('location: my-profile.php');
                exit();
            }
        }
        // METHOD UPDATE MODEL
        public function update_model($lastname, $firstname, $genre, $phone, $address, $birthday, $size, $color_eyes, $color_hair, $email_user_current) {
            global $pdo;

            $user = $this->get_user_talent_by_email($email_user_current, 'talents');
            if($user) {
              $query = $pdo->prepare("UPDATE talents SET lastname=?, firstname=?, genre=?, phone=?, address=?, size=?, color_eyes=?, color_hair=?, birthday =? WHERE email = ?");
              $query->bindValue(1, $lastname);
              $query->bindValue(2, $firstname);
              $query->bindValue(3, $genre);
              $query->bindValue(4, $phone);
              $query->bindValue(5, $address);
              $query->bindValue(6, $size);
              $query->bindValue(7, $color_eyes);
              $query->bindValue(8, $color_hair);
              $query->bindValue(9, $birthday);
              $query->bindValue(10, $email_user_current);

              $query->execute();
              $_SESSION['message_CB'] = 'Votre profil a bien été mis à jour';
              header('location: my-profile.php');
              exit();
            } else {
              header('location: login.php');
              exit();
            }
        }
        //METHOD REGISTER USER
        public function register_user($email, $password, $lastname, $firstname, $genre, $phone) {
            global $pdo;

            $password = md5($password); // hach password
            $keyAccess = $this->generateKey('talents'); // key access user

            setlocale(LC_TIME, "fr_FR");
            $date_register = strftime("%d %B %G");
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
                $query = $pdo->prepare("INSERT INTO users(email, password, firstname, lastname , genre, phone, date_register, type_profile, keyAccess) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $query->bindValue(1, $email);
                $query->bindValue(2, $password);
                $query->bindValue(3, $firstname);
                $query->bindValue(4, $lastname);
                $query->bindValue(5, $genre);
                $query->bindValue(6, $phone);
                $query->bindValue(7, $date_register);
                $query->bindValue(8, 'users');
                $query->bindValue(9, $keyAccess);
                $query->execute();

                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['type_profile'] = "users";
                header('location: my-profile.php');
                exit();
            }
        }

        // METHOD UPDATE user
        public function update_user($lastname, $firstname, $genre, $phone, $email_user_current) {
            global $pdo;

            $user = $this->get_user_talent_by_email($email_user_current, 'users');
            if($user) {
              $query = $pdo->prepare("UPDATE users SET lastname=?, firstname=?, genre=?, phone=?WHERE email = ?");
              $query->bindValue(1, $lastname);
              $query->bindValue(2, $firstname);
              $query->bindValue(3, $genre);
              $query->bindValue(4, $phone);
              $query->bindValue(5, $email_user_current);

              $query->execute();
              $_SESSION['message_CB'] = 'Votre profil a bien été mis à jour';
              header('location: my-profile.php');
              exit();
            } else {
              header('location: login.php');
              exit();
            }
        }
        
        public function isJSON($string){
           return is_string($string) && is_array(json_decode($string, true)) ? true : false;
        }

    }
?>
