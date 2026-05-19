<?php

namespace App\Http\Controllers;

use App\Models\PatientMedication;
use App\Models\Patient;
use App\Models\Pharmaceutical;
use Illuminate\Http\Request;

class PatientMedicationController extends Controller
{
    public function index()
    {
        $medications = PatientMedication::with(['patient', 'pharmaceutical'])
            ->paginate(10);
        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        $pharmaceuticals = Pharmaceutical::orderBy('drug_name')->get();
        return view('medications.create', compact('patients', 'pharmaceuticals'));
    }

    public function store(Request $request)
    {
        PatientMedication::create($request->validate([
            'patient_id'       => 'required|integer',
            'drug_no'          => 'required|integer',
            'drug_description' => 'nullable|string|max:255',
            'dosage'           => 'nullable|string|max:100',
            'method_of_admin'  => 'required|string',
            'units_per_day'    => 'required|integer|min:1',
            'start_date'       => 'required|date',
            'finish_date'      => 'required|date|after_or_equal:start_date',
        ]));

        return redirect()->route('patient-medications.index')
            ->with('success', 'Medication prescribed.');
    }

    public function edit($id)
    {
        $medication = PatientMedication::findOrFail($id);
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        $pharmaceuticals = Pharmaceutical::orderBy('drug_name')->get();
        return view('medications.edit', compact('medication', 'patients', 'pharmaceuticals'));
    }

    public function update(Request $request, $id)
    {
        $medication = PatientMedication::findOrFail($id);

        $medication->update($request->validate([
            'method_of_admin'  => 'required|string',
            'drug_description' => 'nullable|string|max:255',
            'dosage'           => 'nullable|string|max:100',
            'units_per_day'    => 'required|integer|min:1',
            'start_date'       => 'required|date',
            'finish_date'      => 'required|date|after_or_equal:start_date',
        ]));

        return redirect()->route('patient-medications.index')
            ->with('success', 'Medication updated.');
    }

    public function destroy($id)
    {
        PatientMedication::findOrFail($id)->delete();
        return redirect()->route('patient-medications.index')
            ->with('success', 'Medication removed.');
    }
}