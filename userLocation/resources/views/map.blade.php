@extends('layouts.app')

@section('title', 'Editar Ubicación')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Ubicación</li>
        </ol>
    </nav>

    <h1 class="display-4 mb-4">Edita tu Ubicación</h1>

    <div id="map" style="height: 400px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"></div>

    <form class="mt-4">
        <div class="mb-3">
            <label for="locationName" class="form-label">Nombre de la Ubicación</label>
            <input type="text" class="form-control" id="locationName" placeholder="Introduce un nombre para la ubicación">
        </div>
        <div class="mb-3">
            <label for="locationDescription" class="form-label">Descripción</label>
            <textarea class="form-control" id="locationDescription" rows="3"></textarea>
        </div>
        <button id="saveLocation" class="btn btn-success btn-lg">
            <i class="bi bi-save"></i> Guardar Cambios
        </button>
    </form>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const marker = L.marker([51.505, -0.09], {draggable: true}).addTo(map);
    marker.on('dragend', function() {
        var position = marker.getLatLng();
        marker.setLatLng(new L.LatLng(position.lat, position.lng), {draggable:'true'});
        map.panTo(new L.LatLng(position.lat, position.lng));

        // Realizar solicitud de geocodificación inversa
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.lat}&lon=${position.lng}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Ver la respuesta para entender la estructura y extraer información
                if (data.address) {
                    document.getElementById('locationName').value = data.address.road || 'Calle no encontrada';
                    document.getElementById('locationDescription').value = `Cerca de ${data.address.suburb}, ${data.address.city}`;
                }
            });
    });

    document.getElementById('saveLocation').addEventListener('click', function(e) {
    e.preventDefault();
    const position = marker.getLatLng();
    const name = document.getElementById('locationName').value.trim(); // Obtener el valor y eliminar espacios en blanco
    const description = document.getElementById('locationDescription').value.trim(); // Obtener el valor y eliminar espacios en blanco

    fetch('/map/location', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Token CSRF para seguridad
        },
        body: JSON.stringify({
            latitude: position.lat,
            longitude: position.lng,
            name: name,
            description: description
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        alert('Ubicación guardada correctamente');
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la ubicación: ' + error.message);
    });
});

});
</script>
@endsection
