<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        Appointment::create($request->validate([
            'patient_id'       => 'required|integer',
            'consultant_id'    => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'examination_room' => 'required|string',
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
            'patient_id'       => 'required|integer',
            'consultant_id'    => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'examination_room' => 'required|string',
        ]));

        return redirect()->route('appointments.show', $id)->with('success', 'Appointment updated.');
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled.');
    }
}