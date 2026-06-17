<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Therapist;
use Illuminate\Support\Facades\Hash;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $therapists = [
            [
                'name' => 'Maria Santos',
                'email' => 'maria.therapist@casaparaiso.test',
                'password' => Hash::make('password'),
                'role' => 'therapist',
                'phone' => '09170000001',
                'specialization' => 'Swedish Massage',
                'status' => 'active',
            ],
            [
                'name' => 'Ana Reyes',
                'email' => 'ana.therapist@casaparaiso.test',
                'password' => Hash::make('password'),
                'role' => 'therapist',
                'phone' => '09170000002',
                'specialization' => 'Ventosa Massage',
                'status' => 'active',
            ],
            [
                'name' => 'Carla Mendoza',
                'email' => 'carla.therapist@casaparaiso.test',
                'password' => Hash::make('password'),
                'role' => 'therapist',
                'phone' => '09170000003',
                'specialization' => 'Facial Treatment',
                'status' => 'active',
            ],
            [
                'name' => 'Jenny Cruz',
                'email' => 'jenny.therapist@casaparaiso.test',
                'password' => Hash::make('password'),
                'role' => 'therapist',
                'phone' => '09170000004',
                'specialization' => 'Nail Care',
                'status' => 'inactive',
            ],
            [
                'name' => 'Liza Garcia',
                'email' => 'liza.therapist@casaparaiso.test',
                'password' => Hash::make('password'),
                'role' => 'therapist',
                'phone' => '09170000005',
                'specialization' => 'Body Treatment',
                'status' => 'on_leave',
            ]
        ];

        foreach ($therapists as $t) {
            $user = User::create([
                'name' => $t['name'],
                'email' => $t['email'],
                'password' => $t['password'],
                'role' => $t['role'],
            ]);

            Therapist::create([
                'user_id' => $user->id,
                'phone' => $t['phone'],
                'specialization' => $t['specialization'],
                'status' => $t['status'],
            ]);
        }
    }
}
