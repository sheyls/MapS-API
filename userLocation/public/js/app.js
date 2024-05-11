// Importando Leaflet CSS en el código JavaScript podría ser necesario si usas webpack para manejar todos los assets
import 'leaflet/dist/leaflet.css';

document.addEventListener('DOMContentLoaded', function () {
    const initialCoords = [51.505, -0.09]; // Coordenadas iniciales para centrar el mapa
    const zoomLevel = 13; // Nivel de zoom inicial

    // Inicializar el mapa
    const map = L.map('map').setView(initialCoords, zoomLevel);

    // Añadir una capa de tiles al mapa, utilizando OpenStreetMap u otro proveedor
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Crear un marcador que sea arrastrable y añadirlo al mapa
    const marker = L.marker(initialCoords, {
        draggable: true
    }).addTo(map);

    // Funcionalidad para manejar el evento de 'click' en el botón de guardar
    document.getElementById('saveLocation').addEventListener('click', function () {
        const markerPosition = marker.getLatLng(); // Obtener la nueva posición del marcador
        console.log(`Nueva ubicación guardada: Latitud ${markerPosition.lat}, Longitud ${markerPosition.lng}`);

        // Aquí puedes añadir código para enviar esta nueva ubicación al servidor
        // utilizando fetch API o XMLHttpRequest
        fetch('/api/location/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                latitude: markerPosition.lat,
                longitude: markerPosition.lng
            })
        })
        .then(response => response.json())
        .then(data => alert('Ubicación actualizada con éxito'))
        .catch(error => console.error('Error:', error));
    });
});
