@extends('layouts.app')

@section('title', isset($appointment) ? 'Edit Appointment' : 'New Appointment')

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-header">
        <span class="card-title">{{ isset($appointment) ? 'Reschedule appointment' : 'Schedule new appointment' }}</span>
    </div>

    <form method="POST" action="{{ isset($appointment) ? route('appointments.update', $appointment->appointment_id) : route('appointments.store') }}">
        @csrf
        @if(isset($appointment)) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Patient</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">— Select patient —</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id ?? null) == $patient->id)>
                            {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->id }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Consultant</label>
                <select name="consultant_id" class="form-control" required>
                    <option value="">— Select consultant —</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" @selected(old('consultant_id', $appointment->consultant_id ?? null) == $doctor->id)>
                            {{ $doctor->last_name }}, {{ $doctor->first_name }} {{ $doctor->specialization ? '(' . $doctor->specialization . ')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Appointment date</label>
                <input type="date" name="appointment_date" class="form-control"
                    value="{{ old('appointment_date', $appointment->appointment_date ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Appointment time</label>
                <input type="time" name="appointment_time" class="form-control"
                    value="{{ old('appointment_time', $appointment->appointment_time ?? '') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Examination room</label>
            <input type="text" name="examination_room" class="form-control"
                value="{{ old('examination_room', $appointment->examination_room ?? '') }}" required>
        </div>

        <div style="display:flex; gap:8px; margin-top:1rem;">
            <button type="submit" class="btn btn-primary">{{ isset($appointment) ? 'Save changes' : 'Schedule appointment' }}</button>
            <a href="{{ route('appointments.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
