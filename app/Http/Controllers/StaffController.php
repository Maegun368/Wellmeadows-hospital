<?php

namespace App\Http\Controllers;

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

        $validated = $request->validate([
            'first_name'     => 'required',
            'last_name'      => 'required',
            'position'       => 'required',
            'address'        => 'required',
            'phone'          => 'required',
            'date_of_birth'  => 'required',
            'sex'            => 'required',
            'current_salary' => 'required',
            'hours_per_week' => 'required',
            'contract_type' => 'required',
            'pay_type' => 'required',
            'NIN' => 'required',
            'salary_scale' => 'required',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member added.');
    }

    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.show', compact('staff'));
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $staff->update($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff updated.');
    }

    public function destroy($id)
    {
        Staff::findOrFail($id)->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff deleted.');
    }
}