<?php
// api.php
include 'conexion.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $conexion->prepare($sql);
$stmt->execute(['email' => $data->email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario || !password_verify($data->password, $usuario['password'])) {
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

echo json_encode(["mensaje" => "Bienvenido, {$usuario['nombre']}"]);
?>
