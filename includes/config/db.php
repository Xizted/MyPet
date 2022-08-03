<?php

/**
 * Función para conectarse a la base de datos
 */

function db_connect()
{
    try {
        require_once 'config.php';
        $db_connection = "mysql:host=$host;dbname=$db;charset=UTF8;port=$port";
        $db = new PDO($db_connection, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
