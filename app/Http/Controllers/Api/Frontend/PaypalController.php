<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\BuisnessHour;
use App\Models\Service;
use App\Models\User; // Ensure you import User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash for password hashing
use Illuminate\Support\Facades\Log; // Import Log for logging
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // Import Str for string generation
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PaypalController extends Controller
{

protected $paypal;

    public function __construct()
    {
        // Initialize the PayPal client with API credentials
        $this->paypal = new PayPalClient;
        $this->paypal->setApiCredentials(config('paypal'));
        $this->paypal->setAccessToken($this->paypal->getAccessToken());
    }


public function confirmPaypalPayment(Request $request)
{
    $orderID = $request->input('orderID');
    $appointmentId = $request->input('id');

    // Ensure orderID and appointment ID are provided
    if (!$orderID || !$appointmentId) {
        return response()->json(['success' => false, 'message' => 'Missing orderID or appointment ID']);
    }

    try {
        // Use PayPalService to make API calls

        // Get the order details using the correct method for v2.0
        $orderDetails = $this->paypal->showOrderDetails($orderID);  // Correct method for v2.0

        // Log the order details for debugging
        \Log::info('PayPal Order Details:', $orderDetails);

        // Check if the order has already been captured (order status will be 'COMPLETED')
        if (isset($orderDetails['status']) && $orderDetails['status'] == 'COMPLETED') {
            // Order is completed, handle the appointment payment
            $appointment = Appointment::find($appointmentId);

            if ($appointment) {
                // Update the appointment status to 'paid'
                $appointment->payment_status = 'paid';
                $appointment->payment_method = 'paypal';
                $appointment->status = 'confirmed';

                $appointment->save();

                return response()->json(['success' => true, 'message' => 'Payment confirmed and appointment confirmed']);
            } else {
                \Log::error("Appointment not found for ID: $appointmentId");

                return response()->json(['success' => false, 'message' => 'Appointment not found']);
            }
        } else {
            // If the order is not completed, log the issue and respond
            \Log::error('PayPal payment not completed', ['orderDetails' => $orderDetails]);

            return response()->json(['success' => false, 'message' => 'Payment not completed yet']);
        }
    } catch (\Exception $e) {
        // Handle any unexpected errors
        \Log::error('Error confirming PayPal payment', ['exception' => $e->getMessage()]);

        return response()->json(['success' => false, 'message' => 'An error occurred while processing the payment']);
    }
}


}