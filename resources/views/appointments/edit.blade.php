@extends('layouts.app')
@section('title', 'Reschedule Appointment')
@section('topbar-actions')
    <a href="{{ route('appointments.show', $appointment->appointment_id) }}" class="btn">Back</a>
@endsection
@section('content')
<div class="card" style="max-width:640px">
    <div class="card-title">Reschedule appointment #{{ $appointment->appointment_id }}</div>
    <form method="POST" action="{{ route('appointments.update', $appointment->appointment_id) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Patient</label>
                <select name="patient_id" required>
                    <option value="">— Select patient —</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id) == $patient->id)>
                            {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->id }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Consultant</label>
                <select name="consultant_id" required>
                    <option value="">— Select consultant —</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" @selected(old('consultant_id', $appointment->consultant_id) == $doctor->id)>
                            {{ $doctor->last_name }}, {{ $doctor->first_name }} {{ $doctor->specialization ? '(' . $doctor->specialization . ')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Appointment date</label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
            </div>
            <div class="form-group">
                <label>Appointment time</label>
                <input type="time" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Examination room</label>
            <input type="text" name="examination_room" value="{{ old('examination_room', $appointment->examination_room) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update appointment</button>
    </form>
</div>
@endsection
