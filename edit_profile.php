<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="img/logo.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar Perfil | Audiora</title>
</head>

<body>
    <header>
        <div class="content">
            <form method="post" enctype="multipart/form-data" action="update_profile.php">
                <h3>Editar Perfil</h3>
                <div class="card">
                    <label for="user_image">Imagen de Perfil</label>
                    <input type="file" name="user_image">
                </div>
                <div class="card">
                    <label for="user_password">Nueva Contraseña</label>
                    <input type="password" name="user_password" placeholder="Deja en blanco para no cambiar">
                </div>
                <input type="submit" value="Guardar cambios" class="submit">
            </form>
        </div>
    </header>
</body>

</html>