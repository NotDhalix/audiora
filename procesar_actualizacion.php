<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['UsuarioID']; // Cambiar a UsuarioID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $user_email = $_POST['user_email'];

    // Verificar la contraseña actual antes de realizar actualizaciones
    $query = "SELECT Contraseña FROM usuarios WHERE UsuarioID = $user_id LIMIT 1"; // Cambiar a UsuarioID
    $result = mysqli_query($con, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $hashed_current_password = $row['Contraseña'];

        if (password_verify($current_password, $hashed_current_password)) {
            // Contraseña actual es correcta, proceder con las actualizaciones

            // Actualizar correo electrónico
            $query = "UPDATE usuarios SET Correo = '$user_email' WHERE UsuarioID = $user_id"; // Cambiar a UsuarioID
            mysqli_query($con, $query);

            // Actualizar contraseña si se proporciona una nueva
            if (!empty($new_password)) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE usuarios SET Contraseña = '$hashed_new_password' WHERE UsuarioID = $user_id"; // Cambiar a UsuarioID
                mysqli_query($con, $query);
            }

            // Actualizar imagen de perfil si se proporciona una nueva
            if (!empty($_FILES['profile_image']['tmp_name'])) {
                $new_profile_image = addslashes(file_get_contents($_FILES['profile_image']['tmp_name']));
                $query = "UPDATE usuarios SET ImagenPerfil = '$new_profile_image' WHERE UsuarioID = $user_id"; // Cambiar a UsuarioID
                mysqli_query($con, $query);
            }

            header("Location: welcome.php"); // Redirige a la página principal después de la actualización
            exit();
        } else {
            $msg = "La contraseña actual es incorrecta.";
            header("Location: edit_profile.php?error=$msg"); // Redirige a la página de edición con mensaje de error
            exit();
        }
    }
}
