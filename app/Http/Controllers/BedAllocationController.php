<?php

namespace App\Http\Controllers;

use App\Models\BedAllocation;
use App\Models\Patient;
use App\Models\Ward;
use Illuminate\Http\Request;

class BedAllocationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $allocations = BedAllocation::query()
            ->with(['patient', 'ward'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('patient', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%');

                    if (is_numeric($search)) {
                        $q->orWhere('id', (int) $search);
                    }
                });
            })
            ->latest('allocation_id')
            ->paginate(15)
            ->withQueryString();

        $totalAllocations = BedAllocation::count();
        $occupied         = BedAllocation::whereNull('actual_leave_date')->whereNotNull('date_placed')->count();
        $discharged       = BedAllocation::whereNotNull('actual_leave_date')->count();
        $onWaitingList    = BedAllocation::whereNull('date_placed')->whereNotNull('date_placed_waiting')->count();

        return view('bed-allocations.index', compact(
            'allocations',
            'search',
            'totalAllocations',
            'occupied',
            'discharged',
            'onWaitingList'
        ));
    }

    public function create()
    {
        $wards    = Ward::orderBy('ward_name')->get();
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();

        return view('bed-allocations.create', compact('wards', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'             => 'required|integer|exists:patients,id',
            'ward_id'                => 'required|exists:wards,ward_id',
            'bed_number'             => 'required|integer|min:1',
            'date_placed_waiting'    => 'nullable|date',
            'expected_duration_days' => 'nullable|integer|min:1',
            'date_expected_leave'    => 'nullable|date',
            'date_placed'            => 'nullable|date',
        ]);

        // Determine if this is a waiting-list entry
        $isWaiting = !$request->filled('date_placed') && $request->filled('date_placed_waiting');

        // Only block bed assignment for actual placements
        if (!$isWaiting) {
            $existingBed = BedAllocation::where('ward_id', $request->ward_id)
                ->where('bed_number', $request->bed_number)
                ->whereNull('actual_leave_date')
                ->whereNotNull('date_placed')
                ->first();

            if ($existingBed) {
                return back()->withInput()->with('error', 'Bed is already occupied.');
            }
        }

        BedAllocation::create([
            'patient_id'             => $request->patient_id,
            'ward_id'                => $request->ward_id,
            'bed_number'             => $request->bed_number,
            'date_placed_waiting'    => $request->date_placed_waiting,
            'expected_duration_days' => $request->expected_duration_days,
            'date_expected_leave'    => $request->date_expected_leave,
            'actual_leave_date'      => null,
            'date_placed'            => $request->filled('date_placed')
                ? $request->date_placed
                : ($isWaiting ? null : now()->toDateString()),
        ]);

        $message = $isWaiting ? 'Patient added to waiting list.' : 'Bed assigned successfully.';

        return redirect()
            ->route('bed-allocations.index')
            ->with('success', $message);
    }

    public function show(BedAllocation $bedAllocation)
    {
        return redirect()->route('bed-allocations.edit', $bedAllocation);
    }

    public function edit(BedAllocation $bedAllocation)
    {
        $bedAllocation->load(['patient', 'ward']);
        $wards = Ward::orderBy('ward_name')->get();

        return view('bed-allocations.edit', compact('bedAllocation', 'wards'));
    }

    public function update(Request $request, BedAllocation $bedAllocation)
    {
        $data = $request->validate([
            'ward_id'                => 'required|exists:wards,ward_id',
            'bed_number'             => 'required|integer|min:1',
            'date_placed_waiting'    => 'nullable|date',
            'expected_duration_days' => 'nullable|integer|min:1',
            'date_expected_leave'    => 'nullable|date',
            'date_placed'            => 'nullable|date',
        ]);

        $isWaiting = empty($data['date_placed']) && !empty($data['date_placed_waiting']);

        if (!$isWaiting) {
            $existingBed = BedAllocation::where('ward_id', $data['ward_id'])
                ->where('bed_number', $data['bed_number'])
                ->whereNull('actual_leave_date')
                ->whereNotNull('date_placed')
                ->where('allocation_id', '!=', $bedAllocation->allocation_id)
                ->first();

            if ($existingBed) {
                return back()->withInput()->with('error', 'Bed is already occupied.');
            }
        }

        $bedAllocation->update($data);

        return redirect()
            ->route('bed-allocations.index')
            ->with('success', 'Bed allocation updated.');
    }

    public function destroy(BedAllocation $bedAllocation)
    {
        if ($bedAllocation->actual_leave_date === null) {
            return back()->with('error', 'Discharge the patient before deleting this allocation record.');
        }

        $bedAllocation->delete();

        return redirect()
            ->route('bed-allocations.index')
            ->with('success', 'Allocation record deleted.');
    }

    public function discharge(BedAllocation $bedAllocation)
    {
        $bedAllocation->update([
            'actual_leave_date' => now(),
        ]);

        return back()->with('success', 'Patient discharged successfully.');
    }
}