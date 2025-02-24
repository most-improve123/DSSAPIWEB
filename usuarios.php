<?php
// usuarios.php
include 'conexion.php';
header("Content-Type: application/json");

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtener todos los usuarios
        $sql = "SELECT id, nombre, email FROM usuarios";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
        break;

    case 'PUT':
        // Actualizar usuario
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['id']) && !empty($data['nombre']) && !empty($data['email'])) {
            $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'id' => $data['id']
            ]);
            echo json_encode(["mensaje" => "Usuario actualizado"]);
        } else {
            echo json_encode(["error" => "Datos incompletos"]);
        }
        break;

    case 'DELETE':
        // Eliminar usuario
        $data = json_decode(file_get_contents("php://input"), true);
        if (!empty($data['id'])) {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(['id' => $data['id']]);
            echo json_encode(["mensaje" => "Usuario eliminado"]);
        } else {
            echo json_encode(["error" => "ID no proporcionado"]);
        }
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>

