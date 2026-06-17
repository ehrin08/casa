<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\TherapistAvailability;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource for the logged-in therapist.
     */
    public function index()
    {
        $user = auth()->user();
        $therapist = $user->therapist;

        if (!$therapist) {
            return redirect()->route('therapist.dashboard')->with('error', 'No therapist profile linked to this account.');
        }

        $availabilities = TherapistAvailability::where('therapist_id', $therapist->id)
                            ->where('availability_date', '>=', Carbon::today())
                            ->orderBy('availability_date')
                            ->paginate(15);

        return view('therapist.availability.index', compact('availabilities'));
    }
}
