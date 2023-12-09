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
    <title>Registrar Cancion | Audiora Music</title>
</head>

<body>
    <header style="background-color: #111727;">
        <div class="left_bx1">
            <div class="content">
                <form method="post" action="procesar_registro_cancion.php" enctype="multipart/form-data">
                    <div class="titulo">
                        <a href="pag_canciones.php"><i class="bi bi-arrow-left-circle-fill"></i></a>
                        <h3>Registrar Canción</h3>
                    </div>
                    <div class="card">
                        <label for="titulo_cancion">Título de la Canción</label>
                        <input type="text" name="titulo_cancion" required>
                    </div>
                    <div class="card">
                        <label for="artista_cancion">Artista de la Canción</label>
                        <input type="text" name="artista_cancion" required>
                    </div>
                    <div class="card">
                        <label for="archivo_audio">Archivo de Audio</label>
                        <input type="file" name="archivo_audio" accept="audio/*" required>
                    </div>
                    <div class="card">
                        <label for="imagen_cancion">Imagen de la Canción</label>
                        <input type="file" name="imagen_cancion" accept="image/*" required>
                    </div>
                    <div class="card">
                        <label for="duracion">Duración</label>
                        <input type="text" name="duracion" placeholder="00:00" required>
                    </div>
                    <input type="submit" value="Registrar Canción" class="submit">
                </form>

            </div>
        </div>
    </header>
</body>

</html>