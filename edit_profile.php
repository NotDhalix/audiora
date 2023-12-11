<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['UsuarioID'];

$query = "SELECT * FROM usuarios WHERE UsuarioID = '$user_id' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $user_name_db = $row['NombreUsuario'];
    $user_email_db = $row['Correo'];
    $profile_image_path_db = $row['ImagenPerfil'];
} else {

    header('Location: index.php');
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
    <title>Editar Perfil | Audiora Music</title>
</head>

<body>
    <header style="background-color: #111727;">
        <div class="left_bx1">
            <div class="content">
                <form method="post" action="procesar_actualizacion.php" enctype="multipart/form-data">
                    <div class="titulo">
                        <a href="welcome.php"><i class="bi bi-arrow-left-circle-fill"></i></a>
                        <h3>Editar Perfil</h3>
                    </div>
                    <div class="card">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($row['ImagenPerfil']) ?>" alt="Imagen de perfil actual">
                    </div>
                    <div class="card">
                        <label for="user_name">Nombre de Usuario</label>
                        <input type="text" name="user_name" value="<?php echo $user_name_db; ?>">
                    </div>
                    <div class="card">
                        <label for="user_email">Correo Electrónico</label>
                        <input type="email" name="user_email" value="<?php echo $user_email_db; ?>">
                    </div>
                    <div class="card">
                        <label for="current_password">Contraseña Actual</label>
                        <input type="password" name="current_password" placeholder="Ingresa tu contraseña actual" required>
                    </div>
                    <?php
                    if (isset($_GET['error'])) {
                        $error_message = urldecode($_GET['error']);
                        echo '<h4>' . $error_message . '</h4>';
                    }
                    ?>
                    <div class="card">
                        <label for="new_password">Nueva Contraseña</label>
                        <input type="password" name="new_password" placeholder="Ingresa nueva contraseña">
                    </div>
                    <div class="card">
                        <label for="profile_image">Nueva Imagen de Perfil</label>
                        <input type="file" name="profile_image" accept="image/*">
                    </div>
                    <input type="submit" value="Guardar Cambios" class="submit">
                </form>
            </div>
        </div>
    </header>
</body>

</html>