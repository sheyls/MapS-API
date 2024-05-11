<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        // Aquí actualizas la ubicación en la base de datos, por ejemplo:
        $user = Auth::user();
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();
    
        return response()->json(['message' => 'Ubicación actualizada correctamente']);
    }
    
}
