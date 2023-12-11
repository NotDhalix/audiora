<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}


if (isset($_GET['cancion_id'])) {
    $cancion_id = $_GET['cancion_id'];
} else {

    header('Location: pag_canciones.php');
    exit();
}


$query = "SELECT * FROM canciones WHERE CancionID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $cancion_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $cancion = $result->fetch_assoc();
} else {

    header('Location: pag_canciones.php');
    exit();
}

$stmt->close();
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
    <title>Editar Cancion | Audiora Music</title>
</head>

<body>
    <header style="background-color: #111727;">
        <div class="left_bx1">
            <div class="content">
                <form method="post" action="procesar_edicion_cancion.php" enctype="multipart/form-data">
                    <div class="titulo">
                        <a href="pag_canciones.php"><i class="bi bi-arrow-left-circle-fill"></i></a>
                        <h3>Editar Canción</h3>
                    </div>
                    <input type="hidden" name="cancion_id" value="<?php echo $cancion['CancionID']; ?>">

                    <div class="card">
                        <label>Imagen actual:</label>
                        <img src="data:image/jpg;base64,<?php echo base64_encode($cancion['ImagenCancion']); ?>" alt="Imagen actual">
                    </div>

                    <div class="card">
                        <label for="imagen_cancion">Nueva imagen de la Canción</label>
                        <input type="file" name="imagen_cancion" accept="image/*">
                    </div>


                    <div class="card">
                        <label for="titulo_cancion">Título de la Canción</label>
                        <input type="text" name="titulo_cancion" value="<?php echo htmlspecialchars($cancion['Titulo']); ?>">
                    </div>
                    <div class="card">
                        <label for="artista_cancion">Artista de la Canción</label>
                        <input type="text" name="artista_cancion" value="<?php echo htmlspecialchars($cancion['Artista']); ?>">
                    </div>
                    <div class="card">
                        <label for="artista_colab_cancion">Artistas Colaboradores</label>
                        <input type="text" name="artista_colab_cancion" placeholder="" value="<?php echo htmlspecialchars($cancion['Artista Colaborador']); ?>">
                    </div>

                    <input type="submit" value="Actualizar Canción" class="submit">
                </form>
            </div>
        </div>
    </header>
</body>

</html>