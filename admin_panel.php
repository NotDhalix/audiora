<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador | Audiora</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        body {
            font-family: "Poppins", sans-serif;
        }

        h1 {
            text-align: left;
        }

        h2 {
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

        .btn-delete {
            display: block;
            margin: 20px auto;
            padding: 10px;
            background-color: red;
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

    <h2>Usuarios Registrados en Audiora</h2>

    <div id="userList">
        <?php include('admin_api.php'); ?>
    </div>
    <a href="welcome.php" class="back-btn">Volver</a>
</body>

</html>