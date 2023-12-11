<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['UsuarioID'];
    $nueva_imagen_temporal = $_FILES['nueva_imagen_artista']['tmp_name'];
    $nueva_imagen = addslashes(file_get_contents($nueva_imagen_temporal));


    $query_update_artist_image = "UPDATE artistas SET RutaImagenArtista = '$nueva_imagen' WHERE UsuarioID = '$user_id'";
    $result_update_artist_image = mysqli_query($con, $query_update_artist_image);

    if ($result_update_artist_image) {
        header('Location: artista.php?id=' . $artist_id);
        exit();
    } else {
        echo "Error al cambiar la imagen del artista. Por favor, inténtalo de nuevo.";
    }
} else {
    header('Location: pag_canciones.php');
    exit();
}
