<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BuisnessHour; // Ensure this matches your model's actual name

class BuisnessHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $buisnessHours = [
            ['day' => 'monday', 'open_time' => '09:00', 'close_time' => '17:00'],
            ['day' => 'tuesday', 'open_time' => '09:00', 'close_time' => '17:00'],
            ['day' => 'wednesday', 'open_time' => '09:00', 'close_time' => '17:00'],
            ['day' => 'thursday', 'open_time' => '09:00', 'close_time' => '17:00'],
            ['day' => 'friday', 'open_time' => '09:00', 'close_time' => '17:00'],
            ['day' => 'saturday', 'open_time' => '09:00', 'close_time' => '13:00'],
            ['day' => 'sunday', 'open_time' => null, 'close_time' => null], // Use null instead of 'closed'
        ];

        foreach ($buisnessHours as $hour) {
            BuisnessHour::create($hour); // Ensure this matches your model's actual name
        }
    }
}
