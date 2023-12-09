<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cancion_id = $_POST['cancion_id'];
    $titulo_cancion = $_POST['titulo_cancion'];
    // Otros campos según sea necesario

    // Actualizar la información en la base de datos
    $query = "UPDATE canciones SET Titulo = '$titulo_cancion' WHERE CancionID = '$cancion_id'";
    mysqli_query($con, $query);

    header('Location: pag_canciones.php'); // Redirecciona a la página principal
    exit();
} else {
    // Redirecciona si no es una solicitud POST
    header('Location: index.php');
    exit();
}
