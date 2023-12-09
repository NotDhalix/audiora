<?php
session_start();

include('db_connect.php');

if (isset($_SESSION['UsuarioID'])) {
    // Recuperar la información del usuario, incluida la ruta de la imagen de perfil
    $user_id = $_SESSION['UsuarioID']; // Usar UsuarioID
    $query = "SELECT NombreUsuario, ImagenPerfil FROM usuarios WHERE UsuarioID = $user_id LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $user_name = $row['NombreUsuario'];
        $profile_image_path = $row['ImagenPerfil'];
    }
} else {
    // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
    header("Location: index.php");
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
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="media.css">
    <title>Audiora Music</title>
</head>

<body>
    <header>
        <div class="menu_side">
            <h6 id="menu_list_active_button"><i class="bi bi-music-note-list"></i></h6>
            <div class="logo_audiora">
                <img src="img/logo.png" alt="Logo de Audiora" />
                <h1>Audiora Music</h1>
            </div>
            <div class="playlist">
                <h4 class="active"><span></span><i class="bi bi-music-note-beamed"></i> Historial</h4>
                <h4><span></span><i class="bi bi-music-note-beamed"></i> Favoritos</h4>
            </div>
            <div class="menu_song">
                <!-- <li class="songItem">
                    <span>01</span>
                    <img src="img/1.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="1"></i>
                </li> -->
            </div>
        </div>
        <div class="song_side">
            <nav>
                <ul>
                    <li><a href="welcome.php">Descubrir</a></li>
                    <li class="active"><a href="pag_canciones.php">Canciones <span></span></a></li>
                    <li><a href="pag_artistas.php">Artistas</a></li>
                </ul>
                <div class="search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search Music...">
                    <div class="search_results">
                        <!-- <a href="" class="card">
                            <img src="img/1.jpg" alt="">
                            <div class="content">
                                On My Way
                                <div class="subtitle">Alan Walker</div>
                            </div>
                        </a> -->
                    </div>
                </div>
                <div id="profile-container">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($row['ImagenPerfil']) ?>" alt="Imagen de perfil" id="profile-image">
                    <div id="profile-menu">
                        <ul>
                            <a href="edit_profile.php">
                                <li>Editar Perfil</li>
                            </a>
                            <a href="logout.php">
                                <li>Cerrar Sesión</li>
                            </a>
                        </ul>
                    </div>
                </div>

            </nav>
            <div class="content">
                <div class="buttons">
                    <a href="registro_song.php"><button>AGREGAR CANCION</button></a>
                    <button>FOLLOW</button>
                </div>
            </div>
            <div id="canciones-container">
                <section class="canciones-section">
                    <?php
                    // Obtener las canciones del usuario desde la base de datos
                    $query = "SELECT * FROM canciones WHERE UsuarioID = '$user_id'";
                    $result = mysqli_query($con, $query);

                    // Verificar si hay canciones registradas
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="canciones-table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Imagen</th>';
                        echo '<th>Título</th>';
                        echo '<th>Artista</th>';
                        echo '<th>Duración</th>';
                        echo '<th>Audio</th>';
                        echo '<th>Acciones</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr class="cancion-row">';
                            echo '<td class="cancion-image-container"><img src="data:image/jpg;base64,' . base64_encode($row['ImagenCancion']) . '" alt="Imagen de la canción"></td>';
                            echo '<td>' . $row['Titulo'] . '</td>';
                            echo '<td>' . $row['Artista'] . '</td>';
                            echo '<td>' . $row['Duracion'] . '</td>';
                            echo '<td><audio controls><source src="data:audio/mp3;base64,' . base64_encode($row['audio']) . '"></audio></td>';
                            echo '<td>';
                            echo '<a href="editar_cancion.php?cancion_id=' . $row['CancionID'] . '" class="btn-editar"><i class="bi bi-pencil-square"></i></a>';
                            echo '<a href="#" class="btn-eliminar" onclick="confirmarEliminar(' . $row['CancionID'] . ')"><i class="bi bi-trash3-fill"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<p style="margin-left: 100px; font-size: 30px;">No tienes canciones agregadas <i class="bi bi-emoji-frown"></i></p>';
                    }
                    ?>
                </section>
            </div>

        </div>
        <div class="master_play">
            <div class="wave" id="wave">
                <div class="wave1"></div>
                <div class="wave1"></div>
                <div class="wave1"></div>
            </div>
            <img src="img/1.jpg" alt="" id="poster_master_play">
            <h5 id="title"> Oh My Way<div class="subtitle">Alan Walker</div>
            </h5>
            <div class="icon">
                <i class="bi shuffle bi-music-note-beamed">next</i>
                <i class="bi bi-skip-start-fill" id="back"></i>
                <i class="bi bi-play-fill" id="masterPlay"></i>
                <i class="bi bi-skip-end-fill" id="next"></i>
                <a href="" download id="download_music"><i class="bi bi-cloud-arrow-down-fill"></i></a>
            </div>
            <span id="currentStart">0:00</span>
            <div class="bar">
                <input type="range" id="seek" min="0" max="100">
                <div class="bar2" id="bar2"></div>
                <div class="dot"></div>
            </div>
            <span id="currentEnd">3:36</span>
            <div class="vol">
                <i class="bi bi-volume-up-fill" id="vol_icon"></i>
                <input type="range" min="0" max="100" id="vol">
                <div class="vol_bar"></div>
                <div class="dot" id="vol_dot"></div>
            </div>
        </div>
    </header>
    <script src="app.js"></script>
    <script>
        function confirmarEliminar(cancionID) {
            if (confirm("¿Estás seguro de que deseas eliminar esta canción?")) {
                window.location.href = 'procesar_borrado_cancion.php?id=' + cancionID;
            }
        }

        let menu_list_active_button = document.getElementById('menu_list_active_button');
        let menu_side = document.getElementsByClassName('menu_side')[0];


        let song_side = document.getElementsByClassName('song_side')[0];


        let xm = window.matchMedia("(max-width: 930px)");

        menu_list_active_button.addEventListener('click', () => {
            if (xm.matches) {
                menu_side.style.transform = "unset";
                menu_list_active_button.style.opacity = 0;
            }
        })

        song_side.addEventListener('click', () => {
            if (xm.matches) {
                menu_side.style.transform = "translateX(-100%)";
                menu_list_active_button.style.opacity = 1;
            }
        })
    </script>
</body>

</html>