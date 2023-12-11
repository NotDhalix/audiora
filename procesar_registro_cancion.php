<?php
// session_start();

// include('db_connect.php');

// if (!isset($_SESSION['UsuarioID'])) {
//     header('Location: index.php');
//     exit();
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $user_id = $_SESSION['UsuarioID'];
//     $titulo_cancion = $_POST['titulo_cancion'];
//     $artista_cancion = $_POST['artista_cancion'];
//     $archivo_temporal_audio = $_FILES['archivo_audio']['tmp_name'];
//     $archivo_audio = fopen($archivo_temporal_audio, 'rb');
//     $archivo_temporal_imagen = $_FILES['imagen_cancion']['tmp_name'];
//     $archivo_imagen = fopen($archivo_temporal_imagen, 'rb');

//     // Guarda la información en la base de datos
//     $query = "INSERT INTO canciones (Titulo, Artista, audio, ImagenCancion, UsuarioID) VALUES (?, ?, ?, ?, ?)";
//     $stmt = $con->prepare($query);
//     $stmt->bind_param('ssbbi', $titulo_cancion, $artista_cancion, $archivo_audio, $archivo_imagen, $user_id);
//     $stmt->send_long_data(2, fread($archivo_audio, filesize($archivo_temporal_audio)));
//     $stmt->send_long_data(3, fread($archivo_imagen, filesize($archivo_temporal_imagen)));
//     $stmt->execute();
//     $stmt->close();

//     fclose($archivo_audio);
//     fclose($archivo_imagen);

//     header('Location: pag_canciones.php'); // Redirecciona a la página principal
//     exit();
// } else {
//     // Redirecciona si no es una solicitud POST
//     header('Location: index.php');
//     exit();
// }
?>

<?php
session_start();

include('db_connect.php');

if (!isset($_SESSION['UsuarioID'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['UsuarioID'];
    $titulo_cancion = $_POST['titulo_cancion'];
    $artista_cancion = $_POST['artista_cancion'];
    $artista_cancion_colab = $_POST['artista_colab_cancion'];
    $archivo_temporal_audio = $_FILES['archivo_audio']['tmp_name'];
    $archivo_audio = fopen($archivo_temporal_audio, 'rb');
    $archivo_temporal_imagen = $_FILES['imagen_cancion']['tmp_name'];
    $archivo_imagen = fopen($archivo_temporal_imagen, 'rb');

    // Convert the artist image to binary data
    $imagen_artista_path = 'img/pre-avatar.jpg';
    $imagen_artista = file_get_contents($imagen_artista_path);

    // Check if the artist exists
    $query_artist = "SELECT ArtistaID FROM artistas WHERE NombreArtista = ? AND UsuarioID = ?";
    $stmt_artist = $con->prepare($query_artist);
    $stmt_artist->bind_param('si', $artista_cancion, $user_id);
    $stmt_artist->execute();
    $stmt_artist->store_result();

    if ($stmt_artist->num_rows > 0) {
        // Artist exists, retrieve ArtistID
        $stmt_artist->bind_result($artist_id);
        $stmt_artist->fetch();
    } else {
        // Artist does not exist, insert default artist
        $query_insert_artist = "INSERT INTO artistas (NombreArtista, RutaImagenArtista, UsuarioID) VALUES (?, ?, ?)";
        $stmt_insert_artist = $con->prepare($query_insert_artist);
        $stmt_insert_artist->bind_param('sss', $artista_cancion, $imagen_artista, $user_id);
        $stmt_insert_artist->execute();

        // Retrieve the newly inserted ArtistID
        $artist_id = $stmt_insert_artist->insert_id;

        $stmt_insert_artist->close();
    }

    // Insert the song
    $query_insert_song = "INSERT INTO canciones (Titulo, Artista, `Artista Colaborador`, audio, ImagenCancion, UsuarioID, ArtistaID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_song = $con->prepare($query_insert_song);
    $stmt_insert_song->bind_param('sssbbii', $titulo_cancion, $artista_cancion, $artista_cancion_colab, $archivo_audio, $archivo_imagen, $user_id, $artist_id);
    $stmt_insert_song->send_long_data(3, fread($archivo_audio, filesize($archivo_temporal_audio)));
    $stmt_insert_song->send_long_data(4, fread($archivo_imagen, filesize($archivo_temporal_imagen)));
    $stmt_insert_song->execute();
    $stmt_insert_song->close();

    fclose($archivo_audio);
    fclose($archivo_imagen);

    header('Location: pag_canciones.php'); // Redirect to the main page
    exit();
} else {
    // Redirect if it is not a POST request
    header('Location: index.php');
    exit();
}
?>
