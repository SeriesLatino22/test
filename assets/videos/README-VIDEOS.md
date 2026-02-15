# Videos Recomendados para Hero Section

Para la sección hero de tu sitio web de transporte, aquí están los mejores sitios para descargar videos gratis:

## 🎥 Sitios Recomendados

### 1. Pexels Videos
- URL: https://www.pexels.com/videos/
- Búsquedas sugeridas:
  - "truck driving highway"
  - "logistics warehouse"
  - "cargo transport"
  - "delivery truck"
  - "freight transportation"

### 2. Pixabay Videos
- URL: https://pixabay.com/videos/
- Búsquedas sugeridas:
  - "truck road"
  - "logistics"
  - "transportation"
  - "cargo ship"

### 3. Videvo
- URL: https://www.videvo.net/
- Búsquedas sugeridas:
  - "truck driving"
  - "warehouse logistics"
  - "freight"

## 📋 Especificaciones Recomendadas

- **Formato**: MP4 (H.264)
- **Duración**: 10-30 segundos
- **Resolución**: 1920x1080 (Full HD) mínimo
- **Orientación**: Horizontal (landscape)
- **Peso**: Menos de 5MB (optimizado para web)

## 🎬 Tipos de Video Ideales

1. **Camión en carretera** - Vista desde adelante o lateral
2. **Almacén moderno** - Con movimiento de mercancía
3. **Carga y descarga** - Actividad logística
4. **Vista aérea** - De autopistas o centros logísticos
5. **Time-lapse** - De operaciones de transporte

## 🔧 Cómo Implementar

1. Descarga el video de tu elección
2. Guárdalo en: `assets/videos/hero-transport.mp4`
3. Edita `index.php` línea ~95:

```html
<!-- Reemplaza esto: -->
<div class="hero-video" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%);"></div>

<!-- Por esto: -->
<video class="hero-video" autoplay muted loop playsinline>
    <source src="assets/videos/hero-transport.mp4" type="video/mp4">
</video>
```

## 💡 Consejos

- Usa videos con movimiento suave (no muy rápido)
- Prefiere videos con colores azules/grises que combinen con el diseño
- Asegúrate de que el video tenga buena iluminación
- Evita videos con texto o logos de otras empresas
- Optimiza el tamaño del video antes de subirlo

## 🛠️ Optimizar Video (Opcional)

Si el video es muy pesado, puedes optimizarlo con:

### Usando FFmpeg:
```bash
ffmpeg -i input.mp4 -vcodec h264 -acodec aac -b:v 1M -vf scale=1920:1080 hero-transport.mp4
```

### Usando Herramientas Online:
- https://www.freeconvert.com/video-compressor
- https://www.videosmaller.com/

## 📝 Nota

El diseño actual usa un gradiente de fondo como placeholder. El video mejorará significativamente el impacto visual de la página.
