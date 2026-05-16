<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\BedAllocation;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class WardController extends Controller
{
    /**
     * Display all wards
     */
    public function index()
    {
        $wards = Ward::withCount([
            'bedAllocations as occupied_beds' => function ($query) {
                $query->whereNull('actual_leave_date');
            },
        ])->get()->map(function ($ward) {

            $ward->available_beds = $ward->total_beds - $ward->occupied_beds;

            $ward->occupancy_pct = $ward->total_beds > 0
                ? round(($ward->occupied_beds / $ward->total_beds) * 100)
                : 0;

            return $ward;
        });

        $appointmentPatientIds = Appointment::distinct()->pluck('patient_id');

        $patients = Patient::when(
                $appointmentPatientIds->isNotEmpty(),
                fn($query) => $query->whereIn('id', $appointmentPatientIds)
            )
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('wards.index', compact('wards', 'patients'));
    }

    /**
     * Show ward details
     */
    public function show(Ward $ward)
    {
        /*
        |--------------------------------------------------------------------------
        | Current Patients
        |--------------------------------------------------------------------------
        */

        $currentPatients = $ward->bedAllocations()
            ->whereNull('actual_leave_date')
            ->with('patient')
            ->orderBy('bed_number')
            ->get();
    
        /*
        |--------------------------------------------------------------------------
        | Bed Map
        |--------------------------------------------------------------------------
        */

        $bedMap = [];

        for ($i = 1; $i <= $ward->total_beds; $i++) {

            $bedMap[$i] = $currentPatients->firstWhere(
                'bed_number',
                $i
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Waiting List
        |--------------------------------------------------------------------------
        */

        $waitingList = $ward->bedAllocations()
            ->whereNull('date_placed')
            ->whereNotNull('date_placed_waiting')
            ->with('patient')
            ->orderBy('date_placed_waiting')
            ->get();
        /*
        |--------------------------------------------------------------------------
        | Staff
        |--------------------------------------------------------------------------
        */

        $staff = [];

        /*
        |--------------------------------------------------------------------------
        | Available Beds
        |--------------------------------------------------------------------------
        */

        $availableBeds = $ward->availableBeds();

        /*
        |--------------------------------------------------------------------------
        | Appointments for Patients in Ward
        |--------------------------------------------------------------------------
        */

        $patientIds = $currentPatients->pluck('patient_id')->toArray();
        $appointments = Appointment::query()
            ->whereIn('patient_id', $patientIds)
            ->with(['patient', 'consultant'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('wards.show', compact(
            'ward',
            'currentPatients',
            'bedMap',
            'waitingList',
            'staff',
            'availableBeds',
            'appointments'
        ));
    }

    /**
     * Create ward form
     */
    public function create()
    {
        return view('wards.create');
    }

    /**
     * Store ward
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ward_name'           => 'required|string|max:100',
            'location'            => 'required|string|max:150',
            'total_beds'          => 'required|integer|min:1|max:500',
            'telephone_extension' => 'required|string|max:20',
        ]);

        $ward = Ward::create($validated);

        return redirect()
            ->route('wards.index')
            ->with(
                'success',
                "Ward '{$ward->ward_name}' created successfully."
            );
    }

    /**
     * Edit ward form
     */
    public function edit(Ward $ward)
    {
        return view('wards.edit', compact('ward'));
    }

    /**
     * Update ward
     */
    public function update(Request $request, Ward $ward)
    {
        $validated = $request->validate([
            'ward_name'           => 'required|string|max:100',
            'location'            => 'required|string|max:150',
            'total_beds'          => 'required|integer|min:1',
            'telephone_extension' => 'required|string|max:20',
        ]);

        $occupied = $ward->bedAllocations()
            ->whereNull('actual_leave_date')
            ->count();

        if ($validated['total_beds'] < $occupied) {

            return back()
                ->withInput()
                ->withErrors([
                    'total_beds' =>
                    "Cannot reduce beds below occupied count ({$occupied})."
                ]);
        }

        $ward->update($validated);

        return redirect()
            ->route('wards.index')
            ->with(
                'success',
                'Ward updated successfully.'
            );
    }

    /**
     * Delete ward
     */
    public function destroy(Ward $ward)
    {
        $occupied = $ward->bedAllocations()
            ->whereNull('actual_leave_date')
            ->count();

        if ($occupied > 0) {

            return back()->withErrors([
                'ward' =>
                'Cannot delete ward with active bed allocations.'
            ]);
        }

        $ward->delete();

        return redirect()
            ->route('wards.index')
            ->with(
                'success',
                'Ward deleted successfully.'
            );
    }
}