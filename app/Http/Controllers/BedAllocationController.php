<?php

namespace App\Http\Controllers;

use App\Models\BedAllocation;
use App\Models\Ward;
use Illuminate\Http\Request;

class BedAllocationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STORE BED ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'ward_id' => 'required|exists:wards,ward_id',

            'bed_number' => 'required',

            'date_expected_leave' => 'nullable|date',

        ]);

        /*
        |--------------------------------------------------------------------------
        | CHECK IF BED IS OCCUPIED
        |--------------------------------------------------------------------------
        */

        $existingBed = BedAllocation::where('ward_id', $request->ward_id)
            ->where('bed_number', $request->bed_number)
            ->whereNull('actual_leave_date')
            ->first();

        if ($existingBed) {

            return back()->with('error', 'Bed is already occupied.');

        }

        /*
        |--------------------------------------------------------------------------
        | CREATE BED ALLOCATION
        |--------------------------------------------------------------------------
        */

        BedAllocation::create([

            'patient_id' => $request->patient_id,

            'ward_id' => $request->ward_id,

            'bed_number' => $request->bed_number,

            'date_expected_leave' => $request->date_expected_leave,

            'actual_leave_date' => null,

        ]);

        return redirect()
            ->route('wards.index')
            ->with('success', 'Bed assigned successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | DISCHARGE PATIENT
    |--------------------------------------------------------------------------
    */

    public function discharge(BedAllocation $bedAllocation)
    {
        $bedAllocation->update([

            'actual_leave_date' => now(),

        ]);

        return back()->with('success', 'Patient discharged successfully.');
    }
}