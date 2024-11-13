<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Appointment::create([
            'name' => 'John Doe', // Example name
            'email' => 'johndoe@example.com', // Example email
            'phone' => '123-456-7890', // Example phone number
            'service_id' => 1, // Ensure this service_id exists in your services table
            'date' => '2024-11-01',
            'start_time' => '10:00',
            'end_time' => '10:30',
            'status' => 'confirmed',
        ]);

        // You can add more example appointments if needed
        Appointment::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'phone' => '098-765-4321',
            'service_id' => 1,
            'date' => '2024-11-02',
            'start_time' => '11:00',
            'end_time' => '11:30',
            'status' => 'pending',
        ]);
    }
}
