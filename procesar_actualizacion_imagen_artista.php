<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['UsuarioID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artist_id = $_GET['id'];
    $archivo_temporal_imagen = $_FILES['new_image']['tmp_name'];
    $archivo_imagen = fopen($archivo_temporal_imagen, 'rb');


    $query_update_image = "UPDATE artistas SET RutaImagenArtista = ? WHERE ArtistaID = ? AND UsuarioID = ?";
    $stmt_update_image = $con->prepare($query_update_image);
    $stmt_update_image->bind_param('bii', $archivo_imagen, $artist_id, $user_id);
    $stmt_update_image->send_long_data(0, fread($archivo_imagen, filesize($archivo_temporal_imagen)));
    $stmt_update_image->execute();
    $stmt_update_image->close();

    fclose($archivo_imagen);

    header('Location: pag_artistas.php');
    exit();
} else {

    header('Location: pag_artistas.php');
    exit();
}
