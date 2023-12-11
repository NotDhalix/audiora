<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['UsuarioID'])) {
    $user_id = $_SESSION['UsuarioID'];

    if (isset($_GET['id'])) {
        $cancion_id = $_GET['id'];

        // Obtener información del artista asociado a la canción
        $query_artist_info = "SELECT a.ArtistaID FROM artistas a
                              INNER JOIN canciones c ON a.ArtistaID = c.ArtistaID
                              WHERE c.CancionID = '$cancion_id' AND a.UsuarioID = '$user_id'";
        $result_artist_info = mysqli_query($con, $query_artist_info);

        if ($result_artist_info && mysqli_num_rows($result_artist_info) > 0) {
            $row_artist_info = mysqli_fetch_assoc($result_artist_info);
            $artist_id = $row_artist_info['ArtistaID'];

            // Contar cuántas canciones tiene el artista
            $query_count_songs = "SELECT COUNT(*) AS total FROM canciones WHERE ArtistaID = '$artist_id'";
            $result_count_songs = mysqli_query($con, $query_count_songs);

            if ($result_count_songs) {
                $row_count_songs = mysqli_fetch_assoc($result_count_songs);
                $total_songs = $row_count_songs['total'];

                if ($total_songs == 1) {
                    // Si es la única canción del artista, eliminar tanto la canción como el artista
                    $query_delete_song_and_artist = "DELETE canciones, artistas FROM canciones
                                                     LEFT JOIN artistas ON canciones.ArtistaID = artistas.ArtistaID
                                                     WHERE canciones.CancionID = '$cancion_id' AND artistas.ArtistaID = '$artist_id' AND canciones.UsuarioID = '$user_id' AND artistas.UsuarioID = '$user_id'";
                    $result_delete_song_and_artist = mysqli_query($con, $query_delete_song_and_artist);

                    if ($result_delete_song_and_artist) {
                        header('Location: pag_canciones.php');
                        exit();
                    } else {
                        echo "Error al eliminar la canción y el artista. Por favor, inténtalo de nuevo.";
                    }
                } else {
                    // Si hay más canciones del artista, solo eliminar la canción
                    $query_delete_song = "DELETE FROM canciones WHERE CancionID = '$cancion_id' AND UsuarioID = '$user_id'";
                    $result_delete_song = mysqli_query($con, $query_delete_song);

                    if ($result_delete_song) {
                        header('Location: pag_canciones.php');
                        exit();
                    } else {
                        echo "Error al eliminar la canción. Por favor, inténtalo de nuevo.";
                    }
                }
            }
        } else {
            header('Location: pag_canciones.php');
            exit();
        }
    } else {
        header('Location: pag_canciones.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
