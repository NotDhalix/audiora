<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

// Obtener el ID de la canción que se está editando
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancion_id'])) {
    $cancion_id = $_POST['cancion_id'];

    // Verificar si la canción pertenece al usuario actual (opcional)
    $query = "SELECT UsuarioID FROM canciones WHERE CancionID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $cancion_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($row['UsuarioID'] != $_SESSION['UsuarioID']) {
            // La canción no pertenece al usuario actual
            header('Location: pag_canciones.php');
            exit();
        }
    } else {
        // La canción no se encuentra
        header('Location: pag_canciones.php');
        exit();
    }

    // Actualizar imagen de la canción si se proporciona una nueva
    if (!empty($_FILES['imagen_cancion']['tmp_name'])) {
        $new_song_image = fopen($_FILES['imagen_cancion']['tmp_name'], 'rb');  // Abre el archivo en modo binario
        $query = "UPDATE canciones SET ImagenCancion = ? WHERE CancionID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('bi', $new_song_image, $cancion_id);
        $stmt->send_long_data(0, file_get_contents($_FILES['imagen_cancion']['tmp_name']));
        $stmt->execute();
        $stmt->close();
        fclose($new_song_image);  // Cierra el archivo después de enviar los datos
    }

    // Otros campos del formulario (actualiza según tus necesidades)
    $titulo_cancion = $_POST['titulo_cancion'];
    $artista_cancion = $_POST['artista_cancion'];
    $artista_cancion_colab = $_POST['artista_colab_cancion'];

    // Actualizar otros campos de la canción
    $query = "UPDATE canciones SET Titulo = ?, Artista = ?, Duracion = ? WHERE CancionID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssi', $titulo_cancion, $artista_cancion, $artista_cancion_colab, $cancion_id);
    $stmt->execute();
    $stmt->close();

    header("Location: pag_canciones.php"); // Redirige a la página de canciones después de la actualización
    exit();
} else {
    // Redirige si no se reciben datos POST válidos
    header('Location: pag_canciones.php');
    exit();
}
