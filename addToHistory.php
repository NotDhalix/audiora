<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['UsuarioID']) && isset($_POST['cancionId'])) {
    $user_id = $_SESSION['UsuarioID'];
    $cancion_id = $_POST['cancionId'];

    // Insert into historialreproduccion table
    $query = "INSERT INTO historialreproduccion (UsuarioID, CancionID) VALUES ('$user_id', '$cancion_id')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Song added to history successfully";
    } else {
        echo "Error adding song to history";
    }
} else {
    echo "Invalid request";
}
