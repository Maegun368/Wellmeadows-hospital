<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::paginate(10);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
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
        return view('staff.edit', compact('staff'));
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