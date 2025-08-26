<?php

define("DB_HOST", "200.73.113.129");
define("DB_PORT", 3306);
define("DB_NAME", "donaudit_toribio");
define("DB_USER", "donaudit_urstoribio");
define("DB_PASSWORD", "QDRpvu5dV5lR");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


function conexionDinamica($usuario, $clave, $base){
    $conn = new mysqli(DB_HOST, $usuario, $clave, $base);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}