# MapS Laravel API

## Introduction
The Laravel API for the MapS project provides backend services for user authentication, location storage, and real-time geolocation tracking. It utilizes Laravel Sanctum for secure API token management.

## Prerequisites
- PHP 8.0 or higher
- Composer
- Laravel 11
- MySQL

## Setup Instructions

1. Install dependencies
   
    composer install
    
2. Environment Configuration
    Copy .env.example to .env and update with your database settings and other environment variables.
   
    cp .env.example .env
    php artisan key:generate
    
3. Database Migration and Seeding
    Run migrations and seed the database to create necessary tables and initial data.
   
    php artisan migrate --seed
    
4. Serve the API
    Start the Laravel development server on your local machine:
   
    php artisan serve --host 0.0.0.0 --port 8001
    
    The API can now be accessed from your local network.

## API Endpoints

- POST /api/register: Registers a new user.
- POST /api/login: Authenticates a user and returns a token.
- POST /api/map: Stores location data.
- POST /api/logout: Logs out the user and invalidates the token.
- POST /map: Display an interactive map, does not need to be log in. It was developed using `Leaflet.js`

![mapp Large](https://github.com/sheyls/MapS-API/assets/70074598/bb246080-242c-44d4-bbc5-3d60e8ff85b4)

## Authentication
This API uses Laravel Sanctum for handling authentication. Ensure your requests include a valid bearer token to interact with protected routes.

