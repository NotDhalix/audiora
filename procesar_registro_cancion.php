<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['UsuarioID'];
    $titulo_cancion = $_POST['titulo_cancion'];
    $artista_cancion = $_POST['artista_cancion'];
    $duracion = $_POST['duracion'];
    $archivo_temporal_audio = $_FILES['archivo_audio']['tmp_name'];
    $archivo_audio = fopen($archivo_temporal_audio, 'rb');
    $archivo_temporal_imagen = $_FILES['imagen_cancion']['tmp_name'];
    $archivo_imagen = fopen($archivo_temporal_imagen, 'rb');

    // Guarda la información en la base de datos
    $query = "INSERT INTO canciones (Titulo, Artista, audio, ImagenCancion, Duracion, UsuarioID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssbbsi', $titulo_cancion, $artista_cancion, $archivo_audio, $archivo_imagen, $duracion, $user_id);
    $stmt->send_long_data(2, fread($archivo_audio, filesize($archivo_temporal_audio)));
    $stmt->send_long_data(3, fread($archivo_imagen, filesize($archivo_temporal_imagen)));
    $stmt->execute();
    $stmt->close();

    fclose($archivo_audio);
    fclose($archivo_imagen);

    header('Location: pag_canciones.php'); // Redirecciona a la página principal
    exit();
} else {
    // Redirecciona si no es una solicitud POST
    header('Location: index.php');
    exit();
}
