<?php

namespace App\Services;

use App\Models\TherapistAvailability;
use Carbon\Carbon;

class TherapistAvailabilityService
{
    /**
     * Check if a therapist is available on a specific date and time range.
     *
     * @param int $therapistId
     * @param string $date (Y-m-d)
     * @param string $startTime (H:i or H:i:s)
     * @param string $endTime (H:i or H:i:s)
     * @return bool
     */
    public function isTherapistAvailable($therapistId, $date, $startTime, $endTime)
    {
        $availability = TherapistAvailability::where('therapist_id', $therapistId)
            ->where('availability_date', $date)
            ->where('status', 'available')
            ->first();

        if (!$availability) {
            return false;
        }

        $reqStart = Carbon::parse($startTime);
        $reqEnd = Carbon::parse($endTime);
        $availStart = Carbon::parse($availability->start_time);
        $availEnd = Carbon::parse($availability->end_time);

        // Check if requested time is within working hours
        if ($reqStart->lt($availStart) || $reqEnd->gt($availEnd)) {
            return false;
        }

        // Check if requested time overlaps with break time
        if ($availability->break_start_time && $availability->break_end_time) {
            $breakStart = Carbon::parse($availability->break_start_time);
            $breakEnd = Carbon::parse($availability->break_end_time);

            // True if: reqEnd is <= breakStart OR reqStart >= breakEnd
            // So if it's NOT true, they overlap.
            if (!($reqEnd->lte($breakStart) || $reqStart->gte($breakEnd))) {
                return false;
            }
        }

        return true;
    }
}
