<?php
session_start();

include('db_connect.php');
$msg = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_re_password = $_POST['user_re_password'];
    $ImagenPerfil = isset($_FILES['ImagenPerfil']['tmp_name']) ? addslashes(file_get_contents($_FILES['ImagenPerfil']['tmp_name'])) : addslashes(file_get_contents('img/pre-avatar.jpg'));

    if (!empty($user_name) && !empty($user_email) && !empty($user_password) &&  !is_numeric($user_name)) {
        if ($user_password === $user_re_password) {
            // Hash de la contraseña antes de almacenarla en la base de datos
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

            $query = "INSERT INTO usuarios (NombreUsuario, Correo, Contraseña, ImagenPerfil) VALUES ('$user_name', '$user_email', '$hashed_password', '$ImagenPerfil')";
            mysqli_query($con, $query);

            header("Location: index.php");
        } else {
            $msg = "Las contraseñas no coinciden.";
        }
    } else {
        $msg = "Ingresa información válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Registrarse | Audiora </title>
</head>

<body>
    <header>
        <div class="left_bx1">
            <div class="content">
                <form method="post">
                    <h3>Registrarte</h3>
                    <div class="card">
                        <label for="name">Nombre</label>
                        <input type="text" name="user_name" placeholder="" required>
                    </div>
                    <div class="card">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="user_email" placeholder="" required>
                    </div>
                    <div class="card">
                        <label for="password">Contraseña</label>
                        <input type="password" name="user_password" placeholder="" required>
                    </div>
                    <div class="card">
                        <label for="re-password">Ingrese de nuevo la contraseña</label>
                        <input type="password" name="user_re_password" placeholder="" required>
                    </div>
                    <input hidden type="file" name="default_image" placeholder="" value="img/pre-avatar.jpg">
                    <input type="submit" value="Registrarme" class="submit">
                    <div class="check">
                    </div>
                    <p>¿Ya tienes una cuenta? <a href="index.php">Iniciar Sesión</a></p>
                </form>
            </div>
        </div>
        <div class="right_bx1">
            <img src="login_png.jpg" alt="">
            <!-- <h3>Inccorect Password</h3> -->
            <?php
            echo ('<h3>' . $msg . '</h3>');
            ?>
        </div>
    </header>
</body>

</html>