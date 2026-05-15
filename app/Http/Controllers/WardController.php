<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\BedAllocation;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::withCount([
            'bedAllocations as occupied_beds' => function ($query) {
                $query->whereNull('actual_leave_date')
                      ->whereNotNull('date_placed'); // ← FIXED
            },
        ])->get()->map(function ($ward) {

            $ward->available_beds = $ward->total_beds - $ward->occupied_beds;

            $ward->occupancy_pct = $ward->total_beds > 0
                ? round(($ward->occupied_beds / $ward->total_beds) * 100)
                : 0;

            return $ward;
        });

        $patients = \App\Models\Patient::orderBy('last_name')->orderBy('first_name')->get();

        return view('wards.index', compact('wards', 'patients'));
    }

    public function show(Ward $ward)
    {
        /*
        |------------------------------------------------------------------
        | Current Patients — only truly admitted (date_placed is NOT null)
        |------------------------------------------------------------------
        */
        $currentPatients = $ward->bedAllocations()
            ->whereNull('actual_leave_date')
            ->whereNotNull('date_placed') // ← FIXED
            ->with('patient')
            ->orderBy('bed_number')
            ->get();

        /*
        |------------------------------------------------------------------
        | Bed Map
        |------------------------------------------------------------------
        */
        $bedMap = [];

        for ($i = 1; $i <= $ward->total_beds; $i++) {
            $bedMap[$i] = $currentPatients->firstWhere('bed_number', $i);
        }

        /*
        |------------------------------------------------------------------
        | Waiting List — date_placed is null, date_placed_waiting is set
        |------------------------------------------------------------------
        */
        $waitingList = $ward->bedAllocations()
            ->whereNull('actual_leave_date')
            ->whereNull('date_placed')
            ->whereNotNull('date_placed_waiting')
            ->with('patient')
            ->orderBy('date_placed_waiting')
            ->get();

        /*
        |------------------------------------------------------------------
        | Available Beds
        |------------------------------------------------------------------
        */
        $availableBeds = $ward->total_beds - $currentPatients->count();

        $staff = [];

        return view('wards.show', compact(
            'ward',
            'currentPatients',
            'bedMap',
            'waitingList',
            'staff',
            'availableBeds'
        ));
    }

    public function create()
    {
        return view('wards.create');
    }

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
            ->with('success', "Ward '{$ward->ward_name}' created successfully.");
    }

    public function edit(Ward $ward)
    {
        return view('wards.edit', compact('ward'));
    }

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
            ->whereNotNull('date_placed') // ← FIXED
            ->count();

        if ($validated['total_beds'] < $occupied) {
            return back()
                ->withInput()
                ->withErrors([
                    'total_beds' => "Cannot reduce beds below occupied count ({$occupied})."
                ]);
        }

        $ward->update($validated);

        return redirect()
            ->route('wards.index')
            ->with('success', 'Ward updated successfully.');
    }

    public function destroy(Ward $ward)
    {
        $occupied = $ward->bedAllocations()
            ->whereNull('actual_leave_date')
            ->whereNotNull('date_placed') // ← FIXED
            ->count();

        if ($occupied > 0) {
            return back()->withErrors([
                'ward' => 'Cannot delete ward with active bed allocations.'
            ]);
        }

        $ward->delete();

        return redirect()
            ->route('wards.index')
            ->with('success', 'Ward deleted successfully.');
    }
}