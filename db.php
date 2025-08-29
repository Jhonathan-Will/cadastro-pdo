<?php
    try {
        $connection = new PDO("mysql:host=127.0.0.1;dbname=pdo_php", "root", "JH0r1T0s");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Conexão realizada com sucesso!";
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>