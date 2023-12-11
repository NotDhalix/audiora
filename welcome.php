<?php
session_start();

include('db_connect.php');

// Realizar un seguimiento de las visitas
$visit_count = isset($_COOKIE['visit_count']) ? $_COOKIE['visit_count'] + 1 : 1;
setcookie('visit_count', $visit_count, time() + 86400 * 30, '/'); // Cookie válida por 30 días

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
    <link rel="stylesheet" href="style.css">
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
                <?php
                echo '<h4>Bienvenido, esta es tu visita número ' . $visit_count . '.</h4>';
                ?>
                <h4 class="active"><span></span><i class="bi bi-music-note-beamed"></i> Recomendaciones</h4>
                <!-- <h4><span></span><i class="bi bi-music-note-beamed"></i> Favoritos</h4> -->

            </div>
            <div class="menu_song">
                <li class="songItem">
                    <span>01</span>
                    <img src="img/1.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="1"></i>
                </li>
                <li class="songItem">
                    <span>02</span>
                    <img src="img/2.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="2"></i>
                </li>
                <li class="songItem">
                    <span>03</span>
                    <img src="img/2.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="3"></i>
                </li>
                <li class="songItem">
                    <span>04</span>
                    <img src="img/2.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="4"></i>
                </li>
                <li class="songItem">
                    <span>05</span>
                    <img src="img/2.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="5"></i>
                </li>
                <li class="songItem">
                    <span>06</span>
                    <img src="img/2.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="6"></i>
                </li>
                <li class="songItem">
                    <span>07</span>
                    <img src="img/2.jpg" alt="">
                    <h5>On My Way <br>
                        <div class="subtitle">Alan Walker</div>
                    </h5>
                    <i class="bi playListPlay bi-play-circle-fill" id="7"></i>
                </li>

            </div>
        </div>
        <div class="song_side">
            <nav>
                <ul>
                    <li class="active"><a href="pag_descubrir.php">Descubrir<span></span></a></li>
                    <li><a href="pag_canciones.php">Canciones</a></li>
                    <li><a href="pag_artistas.php">Artistas</a></li>
                    <?php if ($_SESSION['UsuarioID'] == 1) { ?>
                        <li><a href="admin_panel.php">Admin Panel</a></li>
                    <?php } ?>
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
                <h1>Alan Walker</h1>
                <p>Alan Olav Walker es un DJ, remezclador y productor discográfico noruego <br> nacido en Northampton, Inglaterra. Es conocido por su sencillo «Faded» de <br>2015, que fue certificado platino en catorce países.</p>
                <div class="buttons">
                    <button>REPRODUCIR</button>
                    <button>SEGUIR</button>
                </div>
            </div>
            <div class="popular_song">
                <div class="h4">
                    <h4>Canciones Populares</h4>
                    <div class="btn_s">
                        <i class="bi bi-arrow-left-short" id="pop_song_left"></i>
                        <i class="bi bi-arrow-right-short" id="pop_song_right"></i>
                    </div>
                </div>
                <div class="pop_song">
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="8"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="9"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="10"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="11"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="12"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="13"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="14"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="15"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="16"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="17"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="18"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/2.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="19"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                    <li class="songItem">
                        <div class="img_play">
                            <img src="img/20.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="20"></i>
                        </div>
                        <h5>On My Way<br>
                            <div class="subtitle">Alan Walker</div>
                        </h5>
                    </li>
                </div>
            </div>
            <div class="popular_artists">
                <div class="h4">
                    <h4>Artistas</h4>
                    <div class="btn_s">
                        <i class="bi bi-arrow-left-short" id="pop_art_left"></i>
                        <i class="bi bi-arrow-right-short" id="pop_art_right"></i>
                    </div>
                </div>
                <div class="item Artists_bx">
                    <li>
                        <img src="Artistas/Don Omar.jpg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Miley Cyrus.jpg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Juicy J.jpg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Bruno Mars.jpg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Camila Cabello.jpeg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Gilberto Santa Rosa.jpg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Marc Anthony.png" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Christian Nodal.webp" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Eminem.webp" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Quevedo.webp" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Pitbull.jpg" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Myke Towers.webp" alt="">
                    </li>
                    <li>
                        <img src="Artistas/Jennifer Lopez.png" alt="">
                    </li>
                </div>
            </div>
        </div>
        <div class="master_play">
            <div class="wave" id="wave">
                <div class="wave1"></div>
                <div class="wave1"></div>
                <div class="wave1"></div>
            </div>
            <img src="img/1.jpg" alt="" id="poster_master_play">
            <h5 id="title"> On My Way <div class="subtitle">Alan Walker</div>
            </h5>
            <div class="icon">
                <i class="bi shuffle bi-music-note-beamed">next</i>
                <i class="bi bi-skip-start-fill" id="back"></i>
                <i class="bi bi-play-fill" id="masterPlay"></i>
                <i class="bi bi-skip-end-fill" id="next"></i>

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