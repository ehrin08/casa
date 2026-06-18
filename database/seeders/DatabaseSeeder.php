<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Casa Paraiso Manager',
            'email' => 'manager@casaparaiso.test',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Sample Therapist',
            'email' => 'therapist@casaparaiso.test',
            'password' => bcrypt('password'),
            'role' => 'therapist',
        ]);

        User::create([
            'name' => 'Sample Customer',
            'email' => 'customer@casaparaiso.test',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $this->call([
            ServiceSeeder::class,
            TherapistSeeder::class,
            TherapistAvailabilitySeeder::class,
            BookingSeeder::class,
            TransactionSeeder::class,
            CommissionSeeder::class,
            PromotionSeeder::class,
        ]);
    }
}
