<?php
    class Event {
        public function fetch_all($tab) {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM $tab ORDER BY CAST(date_depart AS DATE) ASC");
            $query -> execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function fetch_rand($id, $nbr) {
            global $pdo;

            $query = $pdo->prepare("SELECT * FROM events WHERE id != ? ORDER BY RAND() LIMIT $nbr ");
            $query->bindValue(1, $id);
            $query -> execute();
            return $query->fetchAll();
        }
        public function get_event_by_keyAccess($id,$keyAccess, $tab) {
            global $pdo ;

            $query = $pdo->prepare("SELECT * FROM $tab WHERE id = ? AND keyAccess = ? And status = 'post'");
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
        public function fetch_keyWord($key) {
            global $pdo;

            $key = "%$key%";

            $query = $pdo->prepare("SELECT * FROM events WHERE title LIKE ? || content LIKE ? || category LIKE ? || author LIKE ? || date LIKE ?");
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
            $query = $pdo->prepare("SELECT * FROM events WHERE id = ?");
            $query->bindValue(1, $id);
            $query->execute();
            return $query -> fetch();
        }

        public function isJSON($string){
           return is_string($string) && is_array(json_decode($string, true)) ? true : false;
        }

    }
?>
