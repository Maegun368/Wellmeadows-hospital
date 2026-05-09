<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        // Join patient and doctor names for display
        $appointments = DB::table('appointments')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'appointments.consultant_id', '=', 'doctors.id')
            ->select(
                'appointments.*',
                'patients.first_name as patient_first_name',
                'patients.last_name  as patient_last_name',
                'doctors.last_name   as doctor_last_name'
            )
            ->orderBy('appointments.appointment_date', 'asc')
            ->orderBy('appointments.appointment_time', 'asc')
            ->paginate(10);

        // Stats for the right panel cards
        $todayCount   = DB::table('appointments')->whereDate('appointment_date', Carbon::today())->count();
        $waitingCount = DB::table('appointments')
            ->where(function ($q) {
                $q->whereDate('appointment_date', '>', Carbon::today())
                  ->orWhere(function ($q2) {
                      $q2->whereDate('appointment_date', Carbon::today())
                         ->whereTime('appointment_time', '>', Carbon::now()->format('H:i:s'));
                  });
            })->count();
        $doneCount    = DB::table('appointments')
            ->whereDate('appointment_date', Carbon::today())
            ->whereTime('appointment_time', '<', Carbon::now()->format('H:i:s'))
            ->count();

        return view('appointments.index', compact('appointments', 'todayCount', 'waitingCount', 'doneCount'));
    }

    public function create()
    {
        return view('appointments.create');
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
        return view('appointments.edit', compact('appointment'));
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
}