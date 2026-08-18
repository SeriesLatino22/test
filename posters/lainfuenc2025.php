<?php
// Allow caching for 7 days
header("Cache-Control: public, max-age=604800"); // 7 días (604800 segundos)
// header("Pragma: cache"); // Pragma is less relevant with Cache-Control

// Use filemtime for Last-Modified to allow browser caching based on file changes
$fileModifiedTime = filemtime(__FILE__);
header("Last-Modified: " . gmdate("D, d M Y H:i:s", $fileModifiedTime) . " GMT");

$version = '2.0'; // <--  Change this version number to force an update

// Define the message text and chapter number separately for coloring
$messageText = 'Nuevo capitulo: ';
$chapterNumber = '1'; // <-- Change this for the chapter number

$contenido = [


'contenido1' => ['url' => 'https://app.latino7.com/lainfluPlayer.php?play=aHR0cHM6Ly8xYS0xNzkxLmNvbS92aWRlby9md3cxLzZjL3M4LzIvQy9JL3YvaS9DSXZpei5jYWEudGFyP3JfZmlsZT1jaHVua2xpc3QubTN1OCZyX3R5cGU9YXBwbGljYXRpb24lMkZ2bmQuYXBwbGUubXBlZ3VybCZyX3JhbmdlPTQ2ODUzNzM0NC00Njg1NzI4Nzk%3D&fullscreen=1'],





];

$contenidoJson = json_encode($contenido);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latino7</title>
    <script type='text/javascript'>  document.oncontextmenu = function(){return false} </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
  
 body {
    font-family: Arial, sans-serif;
    background-color: #131720;
    color: white;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    overflow-x: hidden;
}

::-webkit-scrollbar {
    width: 0px;
    background-color: transparent;
}

::-webkit-scrollbar-thumb {
    background-color: rgba(15, 15, 15, 0.5);
    border-radius: 10px;
}

::-webkit-scrollbar-track {
    background-color: transparent;
}

scrollbar {
    width: 8px;
    background-color: transparent;
}

scrollbar-thumb {
    background-color: rgba(15, 15, 15, 0.5);
    border-radius: 10px;
}

.player-container {
    width: 100%;
    position: fixed;
    top: 0;
    background-color: #121212;
    box-shadow: 0px 2px 10px rgba(255, 255, 255, 0.1);
    z-index: 1000;
}

.iframe-container {
    width: 100%;
    max-width: 100vw;
    height: 200px;
    border: none;
      margin-top: 36px;
    position: relative;
}

iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Estilos para favoritos - POSICIONADO EN PARTE SUPERIOR */
.icon-bar {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: flex-end; /* Align items to the end (right) */
    align-items: center;
    padding: 10px 15px;
    box-sizing: border-box;
    z-index: 1001;
}

.icon-container {
    position: relative;
    display: inline-block;
}

.icon-btn {
    font-size: 25px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    background: none;
    border: none;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 25px;
    height: 25px;
}

.favorite-btn.active {
    color: red;
}



.fa, .fas {
    font-weight: bolder;
}


.favorite-tooltip {
    position: absolute;
    right: calc(100% + 4px);
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
  font-size: 10px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.2s ease;
    pointer-events: none;
}

.favorite-tooltip.visible {
    opacity: 1;
}

/* Style for version tooltip (kept class definition but element removed) */
.version-tooltip {
    position: absolute; /* Position relative to .icon-bar */
    top: 10px; /* Align with top padding of icon-bar */
    left: 15px; /* Align with left padding of icon-bar */
    /* transform: translateY(-50%); */ /* Not needed when positioned from top */
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px;
    white-space: nowrap;
    pointer-events: none;
    z-index: 1002; /* Ensure it's above other elements */
    opacity: 1; /* Use opacity for fade effect */
    transition: opacity 0.2s ease; /* Add transition */
}

/* Animation for color wave */
@keyframes colorWave {
    0% { color: #caddd8; } /* Starting color */
    33% { color: #a9e3d4; } /* Light green/cyan */
    66% { color: #92aeff; } /* Light blue (matches chapter number color) */
    100% { color: #caddd8; } /* Back to starting color */
}

/* Class for the animated text */
.color-wave-text {
    animation: colorWave 4s infinite alternate; /* 4 seconds duration, infinite loop, reverse direction */
}

/* Mensaje de éxito */
#mensajeExito {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 10px 18px;
    border-radius: 4px;
    z-index: 1000;
    font-size: 15px;
    text-align: center;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.5);
}

.main-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 200px;
}

.episode-list-container {
    width: 100%;
    max-width: 800px;
    padding: 15px 7%;
    box-sizing: border-box;
    margin-top: 45px;
}

.episode-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.episode {
    background-color: #1a1a1a;
    padding: 8px;
    border: 1px solid #000;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: background 0.3s;
    min-height: 60px;
    box-sizing: border-box;
    position: relative;
}

.selected {
    background-color: #373434 !important;
}

.episode img {
    width: 70px;
    height: 47px;
    border-radius: 4px;
    margin-right: 12px;
    object-fit: cover;
}

.episode-info {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.episode strong {
    font-size: 15px;
    margin-bottom: 3px;
}

.episode span {
    font-size: 13px;
    color: #aaa;
}

.play-icon {
    display: none;
    position: absolute;
    right: 12px;
    font-size: 22px;
    color: red;
}

.selected .play-icon {
    display: block;
}

@media (max-width: 768px) {
    .iframe-container {
        height: 170px;
    }

    .main-content {
        margin-top: 170px;
    }

    .episode {
        min-height: 55px;
        padding: 6px;
    }

    .episode img {
        width: 60px;
        height: 40px;
    }
}

@media (max-width: 480px) {
    .iframe-container {
        height: 150px;
    }

    .main-content {
        margin-top: 150px;
    }

    .episode strong {
        font-size: 13px;
    }

    .episode span {
        font-size: 11px;
    }

    .play-icon {
        font-size: 18px;
    }
}

@media (min-width: 769px) {
    .iframe-container {
        height: 130px;
    }
    
    .main-content {
        margin-top: 130px;
    }
}

    </style>
</head>
<body>

    <!-- New Chapter Indicator -->
    <div id="urlVersionIndicator" style="position: fixed; top: 0; left: 0; /* background-color: rgba(0, 0, 0, 0.7); */ color: #caddd8; font-size: 16px; padding: 10px 16px; z-index: 9999; margin-top: 1px; font-weight: bold;">
        <span class="color-wave-text"><?php echo htmlspecialchars($messageText); ?></span><span class="color-wave-text"><?php echo htmlspecialchars($chapterNumber); ?></span>
    </div>

    <div class="player-container">
        <div class="iframe-container" id="contenido-iframe"></div>
        <div class="icon-bar">
            <!-- Container for Favorite Button and Tooltip - Align to the right -->
            <div class="icon-container">
                <button id="favoriteBtn" class="icon-btn favorite-btn">
                    <i class="far fa-heart"></i>
                </button>
                <div id="favoriteTooltip" class="favorite-tooltip">Agregar a favoritos</div>
            </div>
        </div>
    </div>

    <!-- Mensaje de éxito -->
    <div id="mensajeExito">
        <span id="mensajeExitoTexto"></span>
    </div>

    <div class="main-content">
        <div class="episode-list-container">
            <div class="episode-list" id="episodeList">
                <!-- Los episodios se generarán dinámicamente aquí -->
            </div>
        </div>
    </div>

    <script>
        document.oncontextmenu = function() { return false; }

        const paginaActual = {
            url: window.location.href,
          titulo: "La influencer",
        imagen: "portada/1/lainfluImg.webp",
        enlace: "lainfuenc2025"
        };

        const contenidoIframe = document.getElementById('contenido-iframe');
        const episodeList = document.getElementById('episodeList');
        const favoriteBtn = document.getElementById("favoriteBtn");
        const mensajeExito = document.getElementById("mensajeExito");
        const mensajeExitoTexto = document.getElementById("mensajeExitoTexto");
        const favoriteTooltip = document.getElementById("favoriteTooltip");

        let currentIframe = null;
        let isPageVisible = true;
        let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

        const contenido = <?php echo $contenidoJson; ?>;
        const serverVersion = '<?php echo $version; ?>'; // Get version from PHP

        function getLocalStorageKey(key, capituloId) {
            return `${paginaActual.enlace}_${capituloId}_${key}`;
        }

        function mostrarMensaje(texto) {
            mensajeExitoTexto.textContent = texto;
            mensajeExito.style.display = 'block';
            setTimeout(() => {
                mensajeExito.style.display = 'none';
            }, 2500);
        }

        function initFavorites() {
            if (favoritos.some(f => f.enlace === paginaActual.enlace)) {
                favoriteBtn.innerHTML = '<i class="fas fa-heart"></i>';
                favoriteBtn.classList.add("active");
                favoriteTooltip.classList.add("hidden");
            }

            favoriteBtn.addEventListener("click", () => {
                const index = favoritos.findIndex(f => f.enlace === paginaActual.enlace);
                if (index !== -1) {
                    favoritos.splice(index, 1);
                    favoriteBtn.innerHTML = '<i class="far fa-heart"></i>';
                    favoriteBtn.classList.remove("active");
                    favoriteTooltip.classList.remove("hidden");
                    mostrarMensaje("¡Se eliminó de favoritos!");
                } else {
                    // Construir la URL base sin el parámetro de versión
                    const urlBase = window.location.origin + window.location.pathname.split('?')[0];
                    favoritos.push({ titulo: paginaActual.titulo, imagen: paginaActual.imagen, enlace: paginaActual.enlace, url: urlBase });
                    favoriteBtn.innerHTML = '<i class="fas fa-heart"></i>';
                    favoriteBtn.classList.add("active");
                    favoriteTooltip.classList.add("hidden");
                    mostrarMensaje("¡Se añadió a favoritos!");
                }
                localStorage.setItem("favoritos", JSON.stringify(favoritos));
            });
        }

        function actualizarContenido(capituloSeleccionado) {
            if (!capituloSeleccionado) {
                reiniciarContenido();
                return;
            }

            const contenidoSeleccionado = contenido[capituloSeleccionado];
            if (!contenidoSeleccionado) {
                reiniciarContenido();
                return;
            }

            const { url } = contenidoSeleccionado;

            if (currentIframe) {
                contenidoIframe.removeChild(currentIframe);
                currentIframe = null;
            }

            const newIframe = document.createElement('iframe');
            newIframe.id = "inlineFrameResult";
            newIframe.src = url;
            newIframe.frameBorder = 0;
            newIframe.allowFullscreen = true;

            newIframe.addEventListener('load', function() {
                const iframeDoc = this.contentDocument || this.contentWindow.document;
                const video = iframeDoc.querySelector('video');

                if (video) {
                    video.setAttribute('controlsList', 'nodownload');
                    video.preload = 'auto';

                    const savedTime = localStorage.getItem(getLocalStorageKey('video-time', capituloSeleccionado));
                    video.currentTime = savedTime ? parseFloat(savedTime) : 0;

                    video.addEventListener('ended', function() {
                        const capitulos = Object.keys(contenido);
                        const indiceActual = capitulos.indexOf(capituloSeleccionado);

                        if (indiceActual < capitulos.length - 1) {
                            const siguienteCapitulo = capitulos[indiceActual + 1];

                            // Borrar cache del capítulo que terminó
                            localStorage.removeItem(getLocalStorageKey('video-time', capituloSeleccionado));

                            // Ir al siguiente capítulo
                            localStorage.setItem(getLocalStorageKey('capituloActual', paginaActual.enlace), siguienteCapitulo);
                            actualizarContenido(siguienteCapitulo);
                            updateEpisodeSelection(siguienteCapitulo);
                        }
                    });

                    video.addEventListener('canplay', function() {
                        if (isPageVisible) {
                            const playPromise = this.play();
                            if (playPromise !== undefined) {
                                playPromise.catch(error => {
                                    console.log("Autoplay no permitido:", error);
                                });
                            }
                        }
                    });

                    video.addEventListener('timeupdate', function() {
                        localStorage.setItem(getLocalStorageKey('video-time', capituloSeleccionado), this.currentTime);
                    });
                }
            });

            contenidoIframe.appendChild(newIframe);
            currentIframe = newIframe;
        }

        function reiniciarContenido() {
            if (currentIframe) {
                contenidoIframe.removeChild(currentIframe);
                currentIframe = null;
            }
        }

        function updateEpisodeSelection(capituloId) {
            const episodes = document.querySelectorAll('.episode');
            episodes.forEach(ep => {
                ep.classList.remove('selected');
                if (ep.dataset.capitulo === capituloId) {
                    ep.classList.add('selected');
                    ep.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }

        function createEpisodeList() {
            episodeList.innerHTML = '';

            Object.keys(contenido).forEach(key => {
                const cap = contenido[key];
                const episodeElement = document.createElement('div');
                episodeElement.className = 'episode';
                episodeElement.dataset.capitulo = key;

                episodeElement.innerHTML = `
                    <img src="${paginaActual.imagen}" alt="Miniatura">
                    <div class="episode-info">
                        <strong>Capítulo ${key.replace('contenido', '')}</strong>
                        <span>${paginaActual.titulo}</span>
                    </div>
                    <div class="play-icon">▶</div>
                `;

                episodeElement.addEventListener('click', () => {
                    const capituloAnterior = localStorage.getItem(getLocalStorageKey('capituloActual', paginaActual.enlace));
                    if (capituloAnterior && capituloAnterior !== key) {
                        localStorage.removeItem(getLocalStorageKey('video-time', capituloAnterior));
                    }

                    localStorage.setItem(getLocalStorageKey('capituloActual', paginaActual.enlace), key);
                    actualizarContenido(key);
                    updateEpisodeSelection(key);
                    document.title = `${paginaActual.titulo} - Capítulo ${key.replace('contenido', '')}`;
                });

                episodeList.appendChild(episodeElement);
            });
        }

        // Visibilidad de la pestaña
        document.addEventListener('visibilitychange', () => {
            isPageVisible = !document.hidden;
        });

        // Auto scroll al episodio actual al girar o redimensionar
        window.addEventListener("orientationchange", () => {
            setTimeout(() => {
                const capituloActual = localStorage.getItem(getLocalStorageKey('capituloActual', paginaActual.enlace));
                const index = Object.keys(contenido).indexOf(capituloActual);
                const episodioActual = document.querySelectorAll('.episode')[index];
                episodioActual?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500);
        });

        window.addEventListener("resize", () => {
            setTimeout(() => {
                const capituloActual = localStorage.getItem(getLocalStorageKey('capituloActual', paginaActual.enlace));
                const index = Object.keys(contenido).indexOf(capituloActual);
                const episodioActual = document.querySelectorAll('.episode')[index];
                episodioActual?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        });

    window.addEventListener('load', () => {
    const capituloActual = localStorage.getItem(getLocalStorageKey('capituloActual', paginaActual.enlace));
    
    // New versioning logic (kept for consistency, though query param is primary)
    const storedVersion = localStorage.getItem('pageVersion');
    if (storedVersion !== serverVersion) {
        localStorage.setItem('pageVersion', serverVersion);
        // No need for window.location.reload(true); here
        // The webview loading the new URL with the updated version query parameter handles the refresh.
    }

    // Always load content and init features on page load
    createEpisodeList();
    initFavorites();

    // Only show favorite tooltip initially if not favorited
    if (!favoritos.some(f => f.enlace === paginaActual.enlace)) {
        favoriteTooltip.classList.add("visible");
    } else {
        // If already favorited, ensure tooltip is hidden on load
        favoriteTooltip.classList.remove("visible");
    }

    // Ocultar favorite tooltip después de 5 segundos (only applies if shown)
    if(favoriteTooltip.classList.contains("visible")) {
        setTimeout(() => {
            favoriteTooltip.classList.remove("visible");
        }, 5000);
    }

    if (capituloActual && contenido[capituloActual]) {
        actualizarContenido(capituloActual);
        updateEpisodeSelection(capituloActual);
        document.title = `${paginaActual.titulo} - Capítulo ${capituloActual.replace('contenido', '')}`;
    } else if (Object.keys(contenido).length > 0) {
        const firstCapitulo = Object.keys(contenido)[0];
        localStorage.setItem(getLocalStorageKey('capituloActual', paginaActual.enlace), firstCapitulo);
        actualizarContenido(firstCapitulo);
        updateEpisodeSelection(firstCapitulo);
        document.title = `${paginaActual.titulo} - Capítulo ${firstCapitulo.replace('contenido', '')}`;
    }
});


    </script>
</body>
</html>
