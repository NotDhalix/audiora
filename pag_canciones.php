<?php
session_start();

include('db_connect.php');

if (isset($_SESSION['UsuarioID'])) {
    $user_id = $_SESSION['UsuarioID'];
    $query = "SELECT NombreUsuario, ImagenPerfil FROM usuarios WHERE UsuarioID = $user_id LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $user_name = $row['NombreUsuario'];
        $profile_image_path = $row['ImagenPerfil'];
    }
} else {
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
    <title>Audiora Music | Canciones</title>
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
            <?php
            $query = "SELECT h.*, c.Titulo, c.Artista, c.ImagenCancion FROM historialreproduccion h
          JOIN canciones c ON h.CancionID = c.CancionID
          WHERE h.UsuarioID = '$user_id'
          ORDER BY h.HistorialID DESC
          LIMIT 5";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="menu_song">';

                $counter = 01;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li class="songItem">';
                    echo '<span>' . $counter . '</span>';
                    echo '<img src="data:image/jpg;base64,' . base64_encode($row['ImagenCancion']) . '" alt="">';
                    echo '<h5>' . $row['Titulo'] . '<br><div class="subtitle">' . $row['Artista'] . '</div></h5>';
                    echo '<i class="bi playListPlay bi-play-circle-fill" id="' . $row['CancionID'] . '"></i>';
                    echo '</li>';
                    $counter++;
                }
                echo '<a href="#" class="btn-eliminar" onclick="confirmarEliminarHistorial()"><i class="bi bi-trash3-fill"></i></a>';
                echo '</div>';
            } else {
                echo '<p style="margin-left:20px; ">No has reproducido ninguna canción.</p>';
            }
            ?>

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
                    <?php
                    if (!empty($profile_image_path)) {
                        echo '<img src="data:image/jpg;base64,' . base64_encode($profile_image_path) . '" alt="Imagen de perfil" id="profile-image">';
                    } else {
                        echo '<img src="path/to/default/image.jpg" alt="Imagen de perfil por defecto" id="profile-image">';
                    }
                    ?>
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
                    <button>ALEATORIO</button>
                </div>
            </div>

            <div id="canciones-container">
                <?php

                $query = "SELECT * FROM canciones WHERE UsuarioID = '$user_id'";
                $result = mysqli_query($con, $query);


                if (mysqli_num_rows($result) > 0) {
                    echo '<table class="canciones-table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Imagen</th>';
                    echo '<th>Título</th>';
                    echo '<th>Artista</th>';
                    echo '<th>Colaborador</th>';
                    echo '<th id="Audio">Audio</th>';
                    echo '<th>Acciones</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr class="cancion-row">';
                        echo '<td class="cancion-image-container"><img src="data:image/jpg;base64,' . base64_encode($row['ImagenCancion']) . '" alt="Imagen de la canción"></td>';
                        echo '<td>' . $row['Titulo'] . '</td>';
                        echo '<td>' . $row['Artista'] . '</td>';
                        echo '<td>' . $row['Artista Colaborador'] . '</td>';
                        echo '<td><audio controls id="audio' . $row['CancionID'] . '" data-cancion-id="' . $row['CancionID'] . '" data-audio-source="data:audio/mp3;base64,' . base64_encode($row['audio']) . '"><source src="data:audio/mp3;base64,' . base64_encode($row['audio']) . '"></audio></td>';
                        echo '<td>';
                        echo '<button id="btn-reproducir" title="Reproducir Canción" class="play-button" data-cancion-id="' . $row['CancionID'] . '" data-titulo="' . $row['Titulo'] . '" data-artista="' . $row['Artista'] . '" data-imagen="' . base64_encode($row['ImagenCancion']) . '" data-audio-source="data:audio/mp3;base64,' . base64_encode($row['audio']) . '"><i class="bi playListPlay bi-play-circle-fill"></i></button>';
                        echo '<button id="btn-pausa" title="Pausar Canción" class="pause-button" data-cancion-id="' . $row['CancionID'] . '" data-titulo="' . $row['Titulo'] . '" data-artista="' . $row['Artista'] . '" data-imagen="' . base64_encode($row['ImagenCancion']) . '" data-audio-source="data:audio/mp3;base64,' . base64_encode($row['audio']) . '"><i class="bi bi-pause-fill"></i></button>';
                        echo '<a title="Editar Canción" href="editar_cancion.php?cancion_id=' . $row['CancionID'] . '" class="btn-editar"><i class="bi bi-pencil-square"></i></a>';
                        echo '<a title="Eliminar Canción" href="#" class="btn-eliminar" onclick="confirmarEliminar(' . $row['CancionID'] . ')"><i class="bi bi-trash3-fill"></i></a>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p style="margin-left: 100px; font-size: 30px;">No tienes canciones agregadas <i class="bi bi-emoji-frown"></i></p>';
                }
                ?>
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
                <a hidden href="" download id="download_music"><i class="bi bi-cloud-arrow-down-fill"></i></a>
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
    <script>
        function confirmarEliminar(cancionID) {
            if (confirm("¿Estás seguro de que deseas eliminar esta canción?")) {
                window.location.href = 'procesar_borrado_cancion.php?id=' + cancionID;
            }
        }

        function confirmarEliminarHistorial() {
            if (confirm("¿Estás seguro de que deseas eliminar tu historial?")) {
                window.location.href = 'eliminar_historial.php';
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
    <script src="app_canciones.js"></script>
</body>

</html>