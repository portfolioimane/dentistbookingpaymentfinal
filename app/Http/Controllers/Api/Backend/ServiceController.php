<?php

namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        // Fetch all services
        return response()->json(Service::all());
    }

    public function store(Request $request)
    {
        // Validate and create a new service
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric',
            'duration' => 'required|integer', // Duration in minutes
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Image validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Store image if uploaded
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/services', 'public');
            $data['image'] = $path;
        }

        $service = Service::create($data);
        return response()->json($service, 201);
    }

    public function show($id)
    {
        // Fetch a single service by ID
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        // Validate and update a service
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'sometimes|required|numeric',
            'duration' => 'sometimes|required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Image validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service = Service::findOrFail($id);
        $data = $request->all();

        // Store new image if uploaded, and delete the old one
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $path = $request->file('image')->store('images/services', 'public');
            $data['image'] = $path;
        }

        $service->update($data);
        return response()->json($service);
    }

    public function destroy($id)
    {
        // Delete a service
        $service = Service::findOrFail($id);

        // Delete image if exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return response()->json(['message' => 'Service deleted successfully']);
    }
}
