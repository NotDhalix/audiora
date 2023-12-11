<?php

$server_name = "localhost";
$user_name = 'root';
$user_pass = '';
$database_name = "audiora";

$con  = mysqli_connect($server_name, $user_name, $user_pass, $database_name);

if (!$con) {
    die('Conexion Fallida');
}

// else {
//     echo ('Conectado);
// }
