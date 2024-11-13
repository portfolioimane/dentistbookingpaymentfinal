<?php

namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use App\Models\BusinessHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessHourController extends Controller
{
    public function index()
    {
        // Fetch all business hours
        return response()->json(BusinessHour::all());
    }

    public function store(Request $request)
    {
        // Validate and create business hours
        $validator = Validator::make($request->all(), [
            'day_of_week' => 'required|string|unique:business_hours',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $businessHour = BusinessHour::create($request->all());
        return response()->json($businessHour, 201);
    }

    public function show($id)
    {
        // Fetch a single business hour by ID
        $businessHour = BusinessHour::findOrFail($id);
        return response()->json($businessHour);
    }

    public function update(Request $request, $id)
    {
        // Validate and update business hours
        $businessHour = BusinessHour::findOrFail($id);
        $businessHour->update($request->all());

        return response()->json($businessHour);
    }

    public function destroy($id)
    {
        // Delete business hours
        $businessHour = BusinessHour::findOrFail($id);
        $businessHour->delete();

        return response()->json(['message' => 'Business hour deleted successfully']);
    }
}
