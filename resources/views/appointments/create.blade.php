@extends('layouts.app')
@section('title', 'New Appointment')
@section('topbar-actions')
    <a href="{{ route('appointments.index') }}" class="btn">← Back</a>
@endsection
@section('content')
<div class="card" style="max-width:640px">
    <div class="card-title">Schedule an appointment</div>
    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Patient ID</label>
                <input type="number" name="patient_id" value="{{ old('patient_id') }}" required>
                @error('patient_id')<span style="color:#e53e3e;font-size:12px">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Consultant ID</label>
                <input type="number" name="consultant_id" value="{{ old('consultant_id') }}" required>
                @error('consultant_id')<span style="color:#e53e3e;font-size:12px">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Appointment date</label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required>
            </div>
            <div class="form-group">
                <label>Appointment time</label>
                <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required>
            </div>
        </div>
        <div class="form-group">
            <label>Examination room</label>
            <input type="text" name="examination_room" value="{{ old('examination_room') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save appointment</button>
    </form>
</div>
@endsection
