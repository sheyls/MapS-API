<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Location; 

class LocationController extends Controller
{
   // Example of a basic store method in LocationController
public function store(Request $request)
{
    try {
        $location = new Location();
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->name = $request->name;
        $location->description = $request->description;
        $location->save();

        return response()->json(['message' => 'Location saved successfully'], 200);
    } catch (\Exception $e) {
        \Log::error("Location store error: " . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}

    
}
