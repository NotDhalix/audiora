// document.addEventListener("DOMContentLoaded", function () {
//   let playButtons = document.querySelectorAll(".play-button");
//   let currentAudioInstance;

//   playButtons.forEach(function (button) {
//     button.addEventListener("click", function () {
//       let songId = button.getAttribute("data-cancion-id");
//       let audioSource = button.getAttribute("data-audio-source");
//       let imagen = button.getAttribute("data-imagen");
//       let titulo = button.getAttribute("data-titulo");
//       let artista = button.getAttribute("data-artista");

//       let songInfo = {
//         cancionId: songId,
//         audioSource: audioSource,
//         imagen: imagen,
//         titulo: titulo,
//         artista: artista,
//       };

//       if (currentAudioInstance) {
//         currentAudioInstance.pause();
//       }

//       actualizarMasterPlay(songInfo);
//       reproducirEnMasterPlay();
//     });
//   });

//   function actualizarMasterPlay(songInfo) {
//     var titleElement = document.getElementById("title");
//     var posterElement = document.getElementById("poster_master_play");
//     var masterPlayElement = document.getElementById("masterPlay");
//     var seekElement = document.getElementById("seek");

//     titleElement.innerText = songInfo.titulo + " - " + songInfo.artista;
//     posterElement.setAttribute(
//       "src",
//       "data:image/jpg;base64," + songInfo.imagen
//     );
//     masterPlayElement.setAttribute("data-audio-source", songInfo.audioSource);

//     var audioElement = new Audio(songInfo.audioSource);

//     audioElement.addEventListener("loadedmetadata", function () {
//       songInfo.duracion = formatDuracion(audioElement.duration);
//       seekElement.max = audioElement.duration;
//       seekElement.value = 0;

//       var durationElement = document.getElementById("currentEnd");
//       durationElement.innerText = formatDuracion(audioElement.duration);
//     });
//   }

//   function reproducirEnMasterPlay() {
//     var masterPlayElement = document.getElementById("masterPlay");
//     var currentStartElement = document.getElementById("currentStart");
//     var seekElement = document.getElementById("seek");
//     var volElement = document.getElementById("vol");
//     var volBarElement = document.querySelector(".vol_bar");
//     var bar2Element = document.getElementById("bar2");
//     var dotElement = document.querySelector(".dot");
//     var volDotElement = document.getElementById("vol_dot");

//     if (currentAudioInstance) {
//       currentAudioInstance.pause();
//     }

//     var audioSource = masterPlayElement.getAttribute("data-audio-source");
//     var audioElement = new Audio(audioSource);
//     currentAudioInstance = audioElement;

//     audioElement.play();

//     seekElement.addEventListener("input", function () {
//       var progressBar = (seekElement.value / audioElement.duration) * 100;
//       dotElement.style.left = progressBar + "%";
//       bar2Element.style.width = progressBar + "%";
//       audioElement.currentTime =
//         (seekElement.value * audioElement.duration) / 100;
//     });

//     volElement.addEventListener("input", function () {
//       var volValue = volElement.value;
//       volBarElement.style.width = volValue + "%";
//       audioElement.volume = volValue / 100;
//       volDotElement.style.left = volValue + "%";
//     });

//     audioElement.addEventListener("timeupdate", function () {
//       currentStartElement.innerText = formatDuracion(audioElement.currentTime);
//       seekElement.value = audioElement.currentTime;
//       var progressBar =
//         (audioElement.currentTime / audioElement.duration) * 100;
//       seekElement.value = progressBar;
//       dotElement.style.left = progressBar + "%";
//       bar2Element.style.width = progressBar + "%";
//     });

//     masterPlayElement.addEventListener("click", function () {
//       if (audioElement.paused) {
//         audioElement.play();
//       } else {
//         audioElement.pause();
//       }
//     });
//   }

//   function formatDuracion(seconds) {
//     var minutos = Math.floor(seconds / 60);
//     var segundos = Math.floor(seconds % 60);
//     return minutos + ":" + (segundos < 10 ? "0" : "") + segundos;
//   }
// });

document.addEventListener("DOMContentLoaded", function () {
  let playButtons = document.querySelectorAll(".play-button");
  let pauseButtons = document.querySelectorAll(".pause-button");
  let currentAudioInstance;
  let currentPosition = 0;

  playButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      let songInfo = obtenerInfoCancion(button);
      reproducirCancion(songInfo);
    });
  });

  pauseButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      pausarCancion();
    });
  });

  function obtenerInfoCancion(button) {
    let songId = button.getAttribute("data-cancion-id");
    let audioSource = button.getAttribute("data-audio-source");
    let imagen = button.getAttribute("data-imagen");
    let titulo = button.getAttribute("data-titulo");
    let artista = button.getAttribute("data-artista");

    return {
      cancionId: songId,
      audioSource: audioSource,
      imagen: imagen,
      titulo: titulo,
      artista: artista,
    };
  }

  function reproducirCancion(songInfo) {
    if (currentAudioInstance) {
      currentPosition = currentAudioInstance.currentTime; 
      currentAudioInstance.pause();
    }

    actualizarMasterPlay(songInfo);
    reproducirEnMasterPlay();
    addToSongHistory(songInfo.cancionId);
  }
  function addToSongHistory(cancionId) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "addToHistory.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle the response if needed
        console.log(xhr.responseText);
      }
    };

    xhr.send("cancionId=" + encodeURIComponent(cancionId));
  }
  function pausarCancion() {
    if (currentAudioInstance) {
      currentPosition = currentAudioInstance.currentTime;
      currentAudioInstance.pause();
    }
  }
  actualizarMasterPlay(songInfo);
  reproducirEnMasterPlay();
  function actualizarMasterPlay(songInfo) {
    var titleElement = document.getElementById("title");
    var posterElement = document.getElementById("poster_master_play");
    var masterPlayElement = document.getElementById("masterPlay");
    var seekElement = document.getElementById("seek");

    titleElement.innerText = songInfo.titulo + " - " + songInfo.artista;
    posterElement.setAttribute(
      "src",
      "data:image/jpg;base64," + songInfo.imagen
    );
    masterPlayElement.setAttribute("data-audio-source", songInfo.audioSource);

    var audioElement = new Audio(songInfo.audioSource);

    audioElement.addEventListener("loadedmetadata", function () {
      songInfo.duracion = formatDuracion(audioElement.duration);
      seekElement.max = audioElement.duration;
      seekElement.value = 0;

      var durationElement = document.getElementById("currentEnd");
      durationElement.innerText = formatDuracion(audioElement.duration);
    });
  }

  function reproducirEnMasterPlay() {
    var masterPlayElement = document.getElementById("masterPlay");
    var currentStartElement = document.getElementById("currentStart");
    var seekElement = document.getElementById("seek");
    var volElement = document.getElementById("vol");
    var volBarElement = document.querySelector(".vol_bar");
    var bar2Element = document.getElementById("bar2");
    var dotElement = document.querySelector(".dot");
    var volDotElement = document.getElementById("vol_dot");

    if (currentAudioInstance) {
      currentAudioInstance.pause();
    }

    var audioSource = masterPlayElement.getAttribute("data-audio-source");
    var audioElement = new Audio(audioSource);
    currentAudioInstance = audioElement;

    audioElement.play();

    seekElement.addEventListener("input", function () {
      var progressBar = (seekElement.value / audioElement.duration) * 100;
      dotElement.style.left = progressBar + "%";
      bar2Element.style.width = progressBar + "%";
      audioElement.currentTime =
        (seekElement.value * audioElement.duration) / 100;
    });

    volElement.addEventListener("input", function () {
      var volValue = volElement.value;
      volBarElement.style.width = volValue + "%";
      audioElement.volume = volValue / 100;
      volDotElement.style.left = volValue + "%";
    });

    audioElement.addEventListener("timeupdate", function () {
      currentStartElement.innerText = formatDuracion(audioElement.currentTime);
      seekElement.value = audioElement.currentTime;
      var progressBar =
        (audioElement.currentTime / audioElement.duration) * 100;
      seekElement.value = progressBar;
      dotElement.style.left = progressBar + "%";
      bar2Element.style.width = progressBar + "%";
    });
  }

  function formatDuracion(seconds) {
    var minutos = Math.floor(seconds / 60);
    var segundos = Math.floor(seconds % 60);
    return minutos + ":" + (segundos < 10 ? "0" : "") + segundos;
  }
});
