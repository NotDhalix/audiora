<?php
// Obtener el ID de la canción desde el parámetro en la URL
$cancion_id = $_GET['id'];

// Obtener la información de la canción desde la base de datos
$query = "SELECT * FROM canciones WHERE CancionID = '$cancion_id'";
$result = mysqli_query($con, $query);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $titulo_cancion = $row['Titulo'];
    // Otros campos necesarios
} else {
    // Manejar el caso en que no se pueda recuperar la información de la canción
    header('Location: welcome.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ... (código existente) ... -->
    <title>Editar Canción | Audiora Music</title>
</head>

<body>
    <header style="background-color: #111727;">
        <div class="left_bx1">
            <div class="content">
                <form method="post" action="procesar_edicion_cancion.php" enctype="multipart/form-data">
                    <div class="titulo">
                        <a href="welcome.php"><i class="bi bi-arrow-left-circle-fill"></i></a>
                        <h3>Editar Canción</h3>
                    </div>
                    <div class="card">
                        <label for="titulo_cancion">Título de la Canción</label>
                        <input type="text" name="titulo_cancion" value="<?php echo $titulo_cancion; ?>" required>
                    </div>
                    <!-- Agregar otros campos según sea necesario -->
                    <input type="hidden" name="cancion_id" value="<?php echo $cancion_id; ?>">
                    <input type="submit" value="Guardar Cambios" class="submit">
                </form>
            </div>
        </div>
    </header>
</body>

</html>