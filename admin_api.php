<?php
session_start();
include('db_connect.php');


if (isset($_SESSION['UsuarioID']) && $_SESSION['UsuarioID'] == 1) {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_SESSION['delete_message'])) {
            echo '<p style="color: green;">' . $_SESSION['delete_message'] . '</p>';
            unset($_SESSION['delete_message']);
        }

        // Endpoint para obtener la lista de usuarios
        $query = "SELECT UsuarioID, NombreUsuario, Correo FROM usuarios";
        $result = mysqli_query($con, $query);
        $users = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }

        echo '<table>';
        echo '<tr><th>Nombre de Usuario</th><th>Correo</th><th>Acciones</th></tr>';
        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . $user['NombreUsuario'] . '</td>';
            echo '<td>' . $user['Correo'] . '</td>';
            echo '<td>
                    <form method="post" action="admin_api.php">
                        <input type="hidden" name="delete_id" value="' . $user['UsuarioID'] . '">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>';
            echo '</tr>';
        }
        echo '</table>';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {

        $user_id_to_delete = $_POST['delete_id'];

        $delete_query = "DELETE FROM usuarios WHERE UsuarioID = $user_id_to_delete";
        mysqli_query($con, $delete_query);

        $_SESSION['delete_message'] = 'Usuario eliminado correctamente';
        header('Location: admin_panel.php');
        exit();
    }
} else {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}
