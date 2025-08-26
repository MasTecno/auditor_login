<?php

require_once 'config.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$servidor = $data["servidor"];
$email = $data["email"];
$password = $data["password"];

// echo json_encode([
//     "success" => true,
//     "message" => "Datos recibidos correctamente",
//     "data" => $data
// ]);

// exit;

$sql = "SELECT * FROM users where nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $servidor);
$stmt->execute();
$result = $stmt->get_result();


while ($row = $result->fetch_assoc()) {
    $base = $row["nom_bd_conta"];
    $usuario_bd = $row["usuario_bd"];
    $password_bd = $row["password_bd"];
}

$conexion = conexionDinamica($usuario_bd, $password_bd, $base);

$sql = "SELECT * FROM usuarios where email = ? AND password = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "error" => true,
        "message" => "Usuario o contraseña incorrectos"
    ]);
    exit;
}

while ($usuario = $result->fetch_assoc()) {
    $_SESSION["usuario"] = $usuario["nombre"] . " " . $usuario["ape_paterno"];
    $_SESSION["email"] = $usuario["email"];
    
    echo json_encode([
        "success" => true,
        "message" => "Autenticación exitosa"
    ]);
    exit;
}

// $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'users' 
// AND COLUMN_NAME LIKE 'nom_bd_%'";

// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $result = $stmt->get_result();

// $sufijos = [];
// while ($col = $result->fetch_assoc()) {
//     $nombre = str_replace("nom_bd_", "", $col["COLUMN_NAME"]);
//     $sufijos[] = $nombre;
// }

// // print_r($sufijos);

// $conexion_bases = [];

// foreach ($sufijos as $sufijo) {
//     $sql = "SELECT nom_bd_{$sufijo} FROM users WHERE nombre = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $servidor);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     while ($row = $result->fetch_assoc()) {
//         $nombre_bd = $row["nom_bd_" . $sufijo];
//         // echo "Conectando a base: $nombre_bd<br>";

//         $conexion = new mysqli(DB_HOST, $usuario_bd, $password_bd, $nombre_bd);

//         if ($conexion->connect_error) {
//             die("Conexión fallida a $nombre_bd: " . $conexion->connect_error);
//         } else {
//             echo "Conexión exitosa a $nombre_bd<br>";
//         }

//         $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
//         $stmt = $conexion->prepare($sql);
//         $stmt->bind_param("ss", $email, $password);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         while ($usuario = $result->fetch_assoc()) {
//             echo "<pre>";
//             print_r($usuario);
//             echo "</pre>";
//         }
//     }
// }



$conn->close();
?>

