<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        .back-btn {
            display: block;
            margin: 20px auto;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            text-align: center;
            width: 150px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Panel de Administrador</h1>

    <a href="welcome.php" class="back-btn">Volver</a>

    <h2>Usuarios Registrados en Audiora</h2>

    <div id="userList">
        <?php include('admin_api.php'); ?>
    </div>
</body>

</html>