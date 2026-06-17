<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Therapist;
use App\Models\TherapistAvailability;
use Carbon\Carbon;

class TherapistAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $therapists = Therapist::all();
        $startDate = Carbon::today();
        
        foreach ($therapists as $therapist) {
            for ($i = 0; $i < 14; $i++) {
                $currentDate = $startDate->copy()->addDays($i);
                
                // If it's Sunday (0), maybe some are off
                $isSunday = $currentDate->dayOfWeek === 0;

                if ($therapist->status === 'inactive') {
                    // Inactive therapist
                    TherapistAvailability::create([
                        'therapist_id' => $therapist->id,
                        'availability_date' => $currentDate->format('Y-m-d'),
                        'status' => 'unavailable',
                        'notes' => 'Therapist is inactive',
                    ]);
                } elseif ($therapist->status === 'on_leave') {
                    // On leave therapist
                    TherapistAvailability::create([
                        'therapist_id' => $therapist->id,
                        'availability_date' => $currentDate->format('Y-m-d'),
                        'status' => 'on_leave',
                        'notes' => 'Approved leave',
                    ]);
                } else {
                    // Active therapist schedules
                    if ($isSunday) {
                        TherapistAvailability::create([
                            'therapist_id' => $therapist->id,
                            'availability_date' => $currentDate->format('Y-m-d'),
                            'status' => 'unavailable',
                            'notes' => 'Sunday day off',
                        ]);
                    } else {
                        // Different schedules based on specialization
                        if (str_contains(strtolower($therapist->specialization), 'massage')) {
                            TherapistAvailability::create([
                                'therapist_id' => $therapist->id,
                                'availability_date' => $currentDate->format('Y-m-d'),
                                'start_time' => '10:00:00',
                                'end_time' => '19:00:00',
                                'break_start_time' => '13:00:00',
                                'break_end_time' => '14:00:00',
                                'status' => 'available',
                            ]);
                        } else {
                            TherapistAvailability::create([
                                'therapist_id' => $therapist->id,
                                'availability_date' => $currentDate->format('Y-m-d'),
                                'start_time' => '09:00:00',
                                'end_time' => '17:00:00',
                                'break_start_time' => '12:00:00',
                                'break_end_time' => '13:00:00',
                                'status' => 'available',
                            ]);
                        }
                    }
                }
            }
        }
    }
}
