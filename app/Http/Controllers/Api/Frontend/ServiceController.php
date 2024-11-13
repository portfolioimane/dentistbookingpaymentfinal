<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        // Fetch all services
        $services = Service::all(); // Retrieve all services from the database
        return response()->json($services); // Return the services as JSON response
    }
}
