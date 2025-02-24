<?php
// login.php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->email) && isset($data->password)) {
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['email' => $data->email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($data->password, $usuario['password'])) {
        echo json_encode(["mensaje" => "Login exitoso", "usuario" => $usuario['nombre']]);
    } else {
        echo json_encode(["error" => "Credenciales incorrectas"]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
?>
