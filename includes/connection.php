<?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root');
    }catch (PDOException $e) {
        exit('Database error');
    }
    session_start();
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
?>
