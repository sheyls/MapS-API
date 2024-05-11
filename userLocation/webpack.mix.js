const mix = require('laravel-mix');

// Compilar CSS
mix.sass('resources/css/app.css', 'public/css');

// Compilar JavaScript
mix.js('resources/js/app.js', 'public/js');
