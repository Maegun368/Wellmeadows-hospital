<?php

namespace App\Http\Controllers;

use App\Models\PatientMedication;
use Illuminate\Http\Request;

class PatientMedicationController extends Controller
{
    public function index()
    {
        $medications = PatientMedication::paginate(10);
        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        return view('medications.create');
    }

    public function store(Request $request)
    {
        PatientMedication::create($request->validate([
            'patient_id'     => 'required|integer',
            'drug_no'        => 'required|integer',
            'method_of_admin'=> 'required|string',
            'units_per_day'  => 'required|integer',
            'start_date'     => 'required|date',
            'finish_date'    => 'required|date|after_or_equal:start_date',
        ]));

        return redirect()->route('patient-medications.index')->with('success', 'Medication prescribed.');
    }

    public function edit($id)
    {
        $medication = PatientMedication::findOrFail($id);
        return view('medications.edit', compact('medication'));
    }

    public function update(Request $request, $id)
    {
        $medication = PatientMedication::findOrFail($id);

        $medication->update($request->validate([
            'patient_id'     => 'required|integer',
            'drug_no'        => 'required|integer',
            'method_of_admin'=> 'required|string',
            'units_per_day'  => 'required|integer',
            'start_date'     => 'required|date',
            'finish_date'    => 'required|date|after_or_equal:start_date',
        ]));

        return redirect()->route('patient-medications.index')->with('success', 'Medication updated.');
    }

    public function destroy($id)
    {
        PatientMedication::findOrFail($id)->delete();
        return redirect()->route('patient-medications.index')->with('success', 'Medication removed.');
    }
}