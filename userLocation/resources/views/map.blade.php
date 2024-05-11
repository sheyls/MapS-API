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
        map.panTo(new L.LatLng(position.lat, position.lng))
    });

    document.getElementById('saveLocation').addEventListener('click', function(e) {
        e.preventDefault();
        var position = marker.getLatLng();
        console.log(`Location saved: Latitude ${position.lat}, Longitude ${position.lng}`);
        // Aquí puedes añadir código para enviar esta ubicación al servidor
    });
});
</script>
@endsection
