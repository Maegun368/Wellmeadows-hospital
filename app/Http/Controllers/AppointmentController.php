<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = DB::table('appointments')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', DB::raw('appointments.consultant_id::bigint'), '=', 'doctors.id')
            ->select(
                'appointments.*',
                'patients.first_name as patient_first_name',
                'patients.last_name  as patient_last_name',
                'doctors.last_name   as doctor_last_name'
            )
            ->when(request('show') !== 'resolved', fn($q) => $q->whereNull('appointments.outcome'))
            ->when(request('show') === 'resolved', fn($q) => $q->whereNotNull('appointments.outcome'))
            ->orderBy('appointments.appointment_date', 'asc')
            ->orderBy('appointments.appointment_time', 'asc')
            ->paginate(10);

        $todayCount   = DB::table('appointments')->whereDate('appointment_date', Carbon::today())->count();
        $waitingCount = DB::table('appointments')
            ->where(function ($q) {
                $q->whereDate('appointment_date', '>', Carbon::today())
                  ->orWhere(function ($q2) {
                      $q2->whereDate('appointment_date', Carbon::today())
                         ->whereTime('appointment_time', '>', Carbon::now()->format('H:i:s'));
                  });
            })->count();
        $doneCount = DB::table('appointments')
            ->whereDate('appointment_date', Carbon::today())
            ->whereTime('appointment_time', '<', Carbon::now()->format('H:i:s'))
            ->whereNotNull('outcome')
            ->count();

        return view('appointments.index', compact('appointments', 'todayCount', 'waitingCount', 'doneCount'));
    }

    public function create()
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        $doctors  = Doctor::orderBy('last_name')->orderBy('first_name')->get();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        Appointment::create($request->validate([
            'patient_id'       => 'required|integer|exists:patients,id',
            'consultant_id'    => 'required|integer|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'examination_room' => 'required|string|max:100',
        ]));

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled.');
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients    = Patient::orderBy('last_name')->orderBy('first_name')->get();
        $doctors     = Doctor::orderBy('last_name')->orderBy('first_name')->get();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update($request->validate([
            'patient_id'       => 'required|integer|exists:patients,id',
            'consultant_id'    => 'required|integer|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'examination_room' => 'required|string|max:100',
        ]));

        return redirect()->route('appointments.show', $id)->with('success', 'Appointment updated.');
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled.');
    }

    /**
     * Mark an appointment as complete and record the clinical outcome.
     * POST appointments/{id}/complete
     */
    public function complete(Request $request, $id)
    {
        $request->validate([
            'outcome' => 'required|in:out_patient,admitted',
        ]);

        $appointment = Appointment::findOrFail($id);

        // Guard: prevent re-processing an already-resolved appointment
        if ($appointment->outcome !== null) {
            return redirect()->route('appointments.index')
                ->with('warning', 'This appointment has already been resolved.');
        }

        if ($request->outcome === 'out_patient') {
            DB::table('out_patients')->insert([
                'patient_id'       => $appointment->patient_id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $appointment->update(['outcome' => 'out_patient']);

            return redirect()->route('appointments.index')
                ->with('success', 'Patient sent to the out-patient clinic.');
        }

        if ($request->outcome === 'admitted') {
            $appointment->update(['outcome' => 'admitted']);

            return redirect()->route('wards.index', ['admit_patient_id' => $appointment->patient_id])
                ->with('info', 'Select a ward to place the patient on the waiting list.');
        }
    }
    
    /**
     * Set the outcome for a completed appointment
     * PATCH appointments/{id}/outcome
     */
    public function outcome(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'outcome' => 'required|in:ward,outpatient,discharge',
        ]);
        
        // Update the appointment with the outcome
        $appointment->update([
            'outcome' => $validated['outcome'],
        ]);
        
        // Handle each outcome type
        if ($validated['outcome'] === 'ward') {
            return redirect()->route('wards.index', ['admit_patient_id' => $appointment->patient_id])->with('info', 'Select a ward to place the patient on the waiting list.');
        } elseif ($validated['outcome'] === 'outpatient') {
            // Add to out_patients
            \DB::table('out_patients')->insert([
                'patient_id' => $appointment->patient_id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->route('appointments.index')->with('success', 'Patient added to outpatient clinic.');
        } else {
            // Discharge - just keep the updated status
            return redirect()->route('appointments.index')->with('success', 'Patient has been discharged.');
        }
    }
}