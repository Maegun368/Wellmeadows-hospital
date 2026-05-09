<?php

namespace App\Http\Controllers;

use App\Models\Patient; // ← correct model
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        Patient::create($request->validate([
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'age'             => 'required|integer',
            'gender'          => 'required|string',
            'contact_number'  => 'required|string',
            'address'         => 'required|string',
            'blood_type'      => 'nullable|string',
            'ward'            => 'nullable|string',
            'bed_number'      => 'nullable|string',
            'admission_date'  => 'nullable|date',
            'medical_record'  => 'nullable|string',
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient added.');
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id); // ← FIXED
        return view('patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id); // ← FIXED
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id); // ← FIXED

        $patient->update($request->validate([
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'age'             => 'required|integer',
            'gender'          => 'required|string',
            'contact_number'  => 'required|string',
            'address'         => 'required|string',
            'blood_type'      => 'nullable|string',
            'ward'            => 'nullable|string',
            'bed_number'      => 'nullable|string',
            'admission_date'  => 'nullable|date',
            'medical_record'  => 'nullable|string',
        ]));

        return redirect()->route('patients.show', $id)->with('success', 'Patient updated.');
    }

    public function destroy($id)
    {
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted.');
    }
}