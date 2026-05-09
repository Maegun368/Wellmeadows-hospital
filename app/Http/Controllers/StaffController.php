<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Ward;
use App\Models\Appointment;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::paginate(10);

        $totalStaff   = Staff::count();
        $totalDoctors = Staff::where('position', 'like', '%Doctor%')
                             ->orWhere('position', 'like', '%Consultant%')
                             ->count();
        $totalNurses  = Staff::where('position', 'like', '%Nurse%')->count();
        $totalWards   = Ward::count();

        $todayAppointments = Appointment::whereDate('appointment_date', today())
            ->take(5)
            ->get();

        $wardOccupancy = Ward::withCount([
            'bedAllocations as occupied' => fn($q) => $q->whereNull('actual_leave_date')
        ])->get()->map(function ($ward) {
            $ward->percentage = $ward->total_beds > 0
                ? round(($ward->occupied / $ward->total_beds) * 100)
                : 0;
            return $ward;
        });

        return view('staff.index', compact(
            'staff',
            'totalStaff',
            'totalDoctors',
            'totalNurses',
            'totalWards',
            'todayAppointments',
            'wardOccupancy'
        ));
    }

    public function create()
    {
        $wards = Ward::orderBy('ward_name')->get();
        return view('staff.create', compact('wards'));
    }

    public function store(Request $request)
    {
        Staff::create($request->validate([
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'position'       => 'required|string',
            'address'        => 'required|string',
            'phone'          => 'required|string',
            'date_of_birth'  => 'required|date',
            'sex'            => 'required|in:Male,Female,Other',
            'current_salary' => 'required|numeric',
            'hours_per_week' => 'required|integer',
            'contract_type'  => 'required|in:Full-time,Part-time',
            'pay_type'       => 'required|in:Monthly,Weekly',
            'NIN'            => 'required|string|unique:staff,NIN',
            'salary_scale'   => 'required|string',
        ]));

        return redirect()->route('staff.index')->with('success', 'Staff member added.');
    }

    public function show(string $id)
    {
        $staff = Staff::with(['qualifications', 'workExperiences', 'wards'])
                      ->findOrFail($id);
        return view('staff.show', compact('staff'));
    }

    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id);
        $wards = Ward::orderBy('ward_name')->get();
        return view('staff.edit', compact('staff', 'wards'));
    }

    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        $staff->update($request->validate([
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'position'       => 'required|string',
            'address'        => 'required|string',
            'phone'          => 'required|string',
            'date_of_birth'  => 'required|date',
            'sex'            => 'required|in:Male,Female,Other',
            'current_salary' => 'required|numeric',
            'hours_per_week' => 'required|integer',
            'contract_type'  => 'required|in:Full-time,Part-time',
            'pay_type'       => 'required|in:Monthly,Weekly',
            'NIN'            => 'required|string|unique:staff,NIN,' . $id . ',staff_id',
            'salary_scale'   => 'required|string',
        ]));

        return redirect()->route('staff.show', $id)->with('success', 'Staff member updated.');
    }

    public function destroy(string $id)
    {
        Staff::findOrFail($id)->delete();
        return redirect()->route('staff.index')->with('success', 'Staff member deleted.');
    }
}