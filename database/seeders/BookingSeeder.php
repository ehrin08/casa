<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Therapist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        if ($customers->isEmpty()) {
            return;
        }

        $services = Service::where('status', 'available')->get();
        if ($services->isEmpty()) {
            return;
        }

        $manager = User::where('role', 'manager')->first();

        // Sample bookings setup to avoid conflicts, mostly using future dates 
        // that match the 14-day availability seeder (which generates from today onwards).
        
        $bookingsData = [
            // Completed yesterday (simulated, we just force the date)
            [
                'days_offset' => -1,
                'start_time' => '10:00:00',
                'service_idx' => 0,
                'status' => 'completed',
                'payment_status' => 'paid',
                'customer_idx' => 0,
                'created_by_manager' => false,
            ],
            // Booked today
            [
                'days_offset' => 0,
                'start_time' => '11:00:00',
                'service_idx' => 1,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 1,
                'created_by_manager' => false,
            ],
            [
                'days_offset' => 0,
                'start_time' => '13:00:00',
                'service_idx' => 2,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 2,
                'created_by_manager' => true, // walk-in/manager created
            ],
            // Cancelled today
            [
                'days_offset' => 0,
                'start_time' => '15:00:00',
                'service_idx' => 0,
                'status' => 'cancelled',
                'payment_status' => 'cancelled',
                'customer_idx' => 0,
                'created_by_manager' => false,
            ],
            // Booked tomorrow
            [
                'days_offset' => 1,
                'start_time' => '09:00:00',
                'service_idx' => 3,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 1,
                'created_by_manager' => false,
            ],
            [
                'days_offset' => 1,
                'start_time' => '10:30:00',
                'service_idx' => 4,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 2,
                'created_by_manager' => false,
            ],
            // Booked in 2 days
            [
                'days_offset' => 2,
                'start_time' => '14:00:00',
                'service_idx' => 1,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 0,
                'created_by_manager' => false,
            ],
            [
                'days_offset' => 2,
                'start_time' => '16:00:00',
                'service_idx' => 2,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 1,
                'created_by_manager' => true,
            ],
            // Booked in 3 days
            [
                'days_offset' => 3,
                'start_time' => '11:00:00',
                'service_idx' => 0,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 2,
                'created_by_manager' => false,
            ],
            // Booked in 4 days
            [
                'days_offset' => 4,
                'start_time' => '15:30:00',
                'service_idx' => 3,
                'status' => 'booked',
                'payment_status' => 'paid',
                'customer_idx' => 0,
                'created_by_manager' => false,
            ],
        ];

        // Ensure we assign to an active therapist
        $therapist = Therapist::where('status', 'active')->first();
        if (!$therapist) {
            return;
        }

        foreach ($bookingsData as $index => $data) {
            $customer = $customers[$data['customer_idx'] ?? 0] ?? $customers->first();
            $service = $services[$data['service_idx'] ?? 0] ?? $services->first();
            
            $date = Carbon::today()->addDays($data['days_offset']);
            // If it's a Sunday, just move it to Monday to avoid the seeded "unavailable" Sunday constraint
            if ($date->isSunday()) {
                $date->addDay();
            }

            $start = Carbon::parse($date->format('Y-m-d') . ' ' . $data['start_time']);
            $end = $start->copy()->addMinutes($service->duration_minutes);

            $ref = 'CPB-' . $date->format('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            Booking::create([
                'booking_reference' => $ref,
                'customer_id' => $customer->id,
                'created_by_user_id' => $data['created_by_manager'] && $manager ? $manager->id : $customer->id,
                'service_id' => $service->id,
                'therapist_id' => $therapist->id,
                'appointment_date' => $date->format('Y-m-d'),
                'start_time' => $start->format('H:i:s'),
                'end_time' => $end->format('H:i:s'),
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => '09123456789',
                'notes' => 'Sample booking notes.',
                'status' => $data['status'],
                'payment_method' => 'cash',
                'payment_status' => $data['payment_status'],
                'service_price' => $service->price,
                'amount_paid' => $data['payment_status'] === 'paid' ? $service->price : 0,
                'notification_status' => 'email_sent',
            ]);
        }
    }
}
