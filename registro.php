<?php
// registro.php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

$nombre = $data->nombre;
$email = $data->email;
$password = password_hash($data->password, PASSWORD_BCRYPT); // Encriptar la contraseña

// Conexión a la base de datos (asegúrate de que esté configurada correctamente)
$host = 'localhost';
$dbname = 'empresa';
$username = 'root';
$password_db = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $email, $password]);

    // Responder con un mensaje de éxito
    echo json_encode(['mensaje' => 'Usuario registrado correctamente']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al registrar usuario: ' . $e->getMessage()]);
}
?>
