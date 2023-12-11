<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['UsuarioID'];

// Obtener información del artista desde la base de datos
if (isset($_GET['id'])) {
    $artist_id = $_GET['id'];
    $query = "SELECT * FROM artistas WHERE ArtistaID = '$artist_id' AND UsuarioID = '$user_id'";
    $result = mysqli_query($con, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $artist_name = $row['NombreArtista'];
        $current_image_path = $row['RutaImagenArtista'];
    } else {
        // Manejar el caso en que no se pueda recuperar la información del artista
        header('Location: pag_artistas.php');
        exit();
    }
} else {
    // Manejar el caso en que no se proporcione el ID del artista
    header('Location: pag_artistas.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="edit-profile-style.css">
    <title>Editar Imagen del Artista | Audiora Music</title>
</head>

<body>
    <header style="background-color: #111727;">
        <div class="left_bx1">
            <div class="content">
                <form method="post" action="procesar_actualizacion_imagen_artista.php?id=<?php echo $artist_id; ?>" enctype="multipart/form-data">
                    <div class="titulo">
                        <a href="pag_artistas.php"><i class="bi bi-arrow-left-circle-fill"></i></a>
                        <h3>Editar Imagen de <?php echo $artist_name; ?></h3>
                    </div>
                    <div class="card">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($current_image_path) ?>" alt="Imagen actual del artista">
                    </div>
                    <div class="card">
                        <label for="new_image">Nueva Imagen del Artista</label>
                        <input type="file" name="new_image" accept="image/*">
                    </div>
                    <input type="submit" value="Guardar Cambios" class="submit">
                </form>
            </div>
        </div>
    </header>
</body>

</html>