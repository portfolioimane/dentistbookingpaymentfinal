<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Service::create([
            'name' => 'Cleaning',
            'description' => 'Teeth cleaning service',
            'cost' => 500,
            'duration' => 30,
            'image' => null, // Optional, only if you want to explicitly set image as null
        ]);

        Service::create([
            'name' => 'Filling',
            'description' => 'Tooth filling service',
            'cost' => 800,
            'duration' => 45,
            'image' => null, // Optional
        ]);
    }
}
