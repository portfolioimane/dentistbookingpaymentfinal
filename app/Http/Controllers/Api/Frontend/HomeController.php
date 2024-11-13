<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch services to display on the home page
        $services = Service::all(); // Retrieve all services
        return response()->json([
            'message' => 'Welcome to the Dentist Booking System',
            'services' => $services,
        ]);
    }
}
