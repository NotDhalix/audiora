<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "audiora";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener datos de la tabla (reemplaza 'tu_tabla' con el nombre de tu tabla)
$sql = "SELECT UsuarioID, NombreUsuario, Correo, Contraseña FROM usuarios";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Convertir resultados a formato JSON
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    // Si no hay resultados
    echo json_encode(array('message' => 'No se encontraron resultados'));
}

// Cerrar la conexión
$conn->close();
