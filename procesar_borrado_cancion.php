<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['UsuarioID'])) {
    $user_id = $_SESSION['UsuarioID'];

    if (isset($_GET['id'])) {
        $cancion_id = $_GET['id'];

        $query = "DELETE FROM canciones WHERE CancionID = '$cancion_id' AND UsuarioID = '$user_id'";
        $result = mysqli_query($con, $query);

        if ($result) {
            header('Location: pag_canciones.php');
            exit();
        } else {
            echo "Error al eliminar la canción. Por favor, inténtalo de nuevo.";
        }
    } else {
        header('Location: pag_canciones.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
