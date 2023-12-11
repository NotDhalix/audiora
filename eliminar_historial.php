<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['UsuarioID'])) {
    $user_id = $_SESSION['UsuarioID'];


    $query = "DELETE FROM historialreproduccion WHERE UsuarioID = '$user_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        header('Location: pag_canciones.php');
        exit();
    } else {
        echo "Error al eliminar la canción. Por favor, inténtalo de nuevo.";
    }
} else {
    echo "Usuario no autenticado";
}
