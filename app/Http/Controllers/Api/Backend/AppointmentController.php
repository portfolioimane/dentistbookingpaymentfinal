<?php
namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {
        // Fetch all appointments with related services
        $appointments = Appointment::with('service')->get();
        return response()->json($appointments);
    }

    public function show($id)
    {
        // Fetch a single appointment by ID with related service
        $appointment = Appointment::with('service')->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        // Validate and update an appointment's status
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,completed,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);

        return response()->json($appointment);
    }

    public function destroy($id)
    {
        // Delete an appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
