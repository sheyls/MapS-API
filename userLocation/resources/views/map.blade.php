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
    let map, marker; 

    function initMap(latitude, longitude) {
        map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        marker = L.marker([latitude, longitude], {draggable: true}).addTo(map);
        marker.on('dragend', updateMarker);
    }

    function updateMarker() {
        const position = marker.getLatLng();
        map.panTo(new L.LatLng(position.lat, position.lng));
        reverseGeocode(position.lat, position.lng);
    }

    function reverseGeocode(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data.address) {
                    document.getElementById('locationName').value = data.address.road || 'Street not found';
                    document.getElementById('locationDescription').value = `Near ${data.address.suburb}, ${data.address.city}`;
                }
            });
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        initMap(position.coords.latitude, position.coords.longitude);
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
        initMap(51.505, -0.09); // Default coordinates if error occurs
    }

    getLocation(); // Get the current location and initialize the map

    document.getElementById('saveLocation').addEventListener('click', function(e) {
        e.preventDefault();
        const position = marker.getLatLng(); // Accessible because marker is now scoped outside initMap
        const name = document.getElementById('locationName').value.trim();
        const description = document.getElementById('locationDescription').value.trim();

        fetch('/map/location', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
