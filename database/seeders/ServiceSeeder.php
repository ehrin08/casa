<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Swedish Massage',
                'category' => 'Massage',
                'price' => 500.00,
                'duration_minutes' => 60,
                'commission_rate' => 22.00,
                'status' => 'available',
                'description' => 'A classic European massage using long, gliding strokes.',
            ],
            [
                'name' => 'Ventosa Massage',
                'category' => 'Massage',
                'price' => 650.00,
                'duration_minutes' => 75,
                'commission_rate' => 22.00,
                'status' => 'available',
                'description' => 'A traditional Chinese massage therapy using cups.',
            ],
            [
                'name' => 'Basic Manicure',
                'category' => 'Nails',
                'price' => 250.00,
                'duration_minutes' => 45,
                'commission_rate' => 22.00,
                'status' => 'available',
                'description' => 'Basic nail cleaning, shaping, and polish.',
            ],
            [
                'name' => 'Facial Cleaning',
                'category' => 'Facial',
                'price' => 700.00,
                'duration_minutes' => 60,
                'commission_rate' => 22.00,
                'status' => 'available',
                'description' => 'Deep pore cleaning with facial massage.',
            ],
            [
                'name' => 'Body Scrub Package',
                'category' => 'Package',
                'price' => 1200.00,
                'duration_minutes' => 90,
                'commission_rate' => 22.00,
                'status' => 'unavailable',
                'description' => 'Full body scrub and light massage package.',
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
