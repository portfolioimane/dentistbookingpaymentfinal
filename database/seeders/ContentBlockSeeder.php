<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentBlock;

class ContentBlockSeeder extends Seeder
{
    public function run()
    {
        ContentBlock::create([
            'section' => 'hero',
            'title' => 'Welcome to Our Dental Clinic',
            'text' => 'Providing quality dental care for over 20 years.',
            'image_path' => '/images/hero.jpg',
            'button_text' => 'Book Now',
        ]);

        ContentBlock::create([
            'section' => 'about',
            'title' => 'About Our Clinic',
            'text' => 'Our clinic is dedicated to providing excellent dental services.',
            'image_path' => '/images/about.jpg',
            'button_text' => null,
        ]);

        ContentBlock::create([
            'section' => 'consultation',
            'title' => 'Free Consultation',
            'text' => 'Book a free consultation to discuss your dental health needs.',
            'image_path' => '/images/consultation.jpg',
            'phone_number' => '123-456-7890',
        ]);

        // New logo section with only an image
        ContentBlock::create([
            'section' => 'logo',
            'image_path' => '/images/logo.png', // Path to your logo image
        ]);
    }
}
