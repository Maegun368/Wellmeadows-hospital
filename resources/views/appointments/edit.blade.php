@extends('layouts.app')
@section('title', 'Update Appointment')
@section('topbar-actions')
    <a href="{{ route('appointments.show', $appointment->appointment_id) }}" class="btn">Back</a>
@endsection
@section('content')
<style>
    /* Match system form styles */
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        border: 1px solid var(--blue-light);
        font-size: 13px;
        color: #2d3748;
        background: #f0f8ff;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--blue-dark);
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(41,128,185,0.15);
    }
    .field-error { color: #e74c3c; font-size: 11px; margin-top: 4px; display: block; }
</style>

<div class="card" style="max-width:720px; margin: 2rem auto;">
    <div class="card-title">Update Appointment #{{ $appointment->appointment_id }}</div>
    <div style="padding:24px">
        <form method="POST" action="{{ route('appointments.update', $appointment->appointment_id) }}">
            @csrf @method('PUT')
            
            <div class="section-label" style="margin-bottom:1rem; padding-bottom:0.5rem; border-bottom:1px solid #e2e8f0; font-weight:600; color:var(--blue-dark); text-transform:uppercase; letter-spacing:0.05em; font-size:13px;">Appointment Details</div>
            
            <div class="form-grid-2">
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
                    @error('patient_id')<span class="field-error">{{ $message }}</span>@enderror
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
                    @error('consultant_id')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Appointment Date</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
                    @error('appointment_date')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Appointment Time</label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                    @error('appointment_time')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
            
            <div class="form-group" style="max-width:50%;">
                <label>Examination Room</label>
                <input type="text" name="examination_room" value="{{ old('examination_room', $appointment->examination_room) }}" placeholder="e.g. Exam Room 1" required>
                @error('examination_room')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            
            <div style="margin-top:2rem; display:flex; gap:12px;">
                <a href="{{ route('appointments.show', $appointment->appointment_id) }}" style="padding:10px 20px; background:#f3f4f6; color:#374151; border:none; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding:10px 24px;">Update Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection