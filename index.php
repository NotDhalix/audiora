<?php

session_start();

include('db_connect.php');
$msg = false;
if (isset($_POST['user_name'])) {
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];

    $query = "select * from user where user = '" . $user_name . "' AND password = '" . $user_password . "' limit 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        header('Location: welcome.php');
    } else {
        $msg = "Credenciales incorrectas.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="img/logo.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Iniciar Sesión | Audiora </title>
</head>

<body>
    <header>
        <div class="left_bx1">
            <div class="content">
                <form method="post">
                    <h3>Iniciar Sesión</h3>
                    <div class="card">
                        <label for="name">Nombre</label>
                        <input type="text" name="user_name" placeholder="" required>
                    </div>
                    <div class="card">
                        <label for="password">Contraseña</label>
                        <input type="password" name="user_password" placeholder="" required>
                    </div>
                    <input type="submit" value="Iniciar sesión" class="submit">
                    <div class="check">
                        <input type="checkbox" name="" id=""><span>Recordar sesión.</span>
                    </div>
                    <p>¿No tienes una cuenta? <a href="signup.php">Registrate aquí.</a></p>
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