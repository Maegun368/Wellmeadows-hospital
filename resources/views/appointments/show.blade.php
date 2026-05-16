@extends('layouts.app')
@section('title', 'Appointment Details')
@section('topbar-actions')
    <a href="{{ route('appointments.index') }}" class="btn">Back</a>
    <a href="{{ route('appointments.edit', $appointment->appointment_id) }}" class="btn" style="margin-left:8px">Edit</a>
@endsection
@section('content')
<div class="card" style="max-width:520px">
    <div class="card-title">Appointment #{{ $appointment->appointment_id }}</div>
    <table>
        <tr><th style="width:40%">Patient ID</th><td>{{ $appointment->patient_id }}</td></tr>
        <tr><th>Consultant ID</th><td>{{ $appointment->consultant_id }}</td></tr>
        <tr><th>Date</th><td>{{ $appointment->appointment_date }}</td></tr>
        <tr><th>Time</th><td>{{ $appointment->appointment_time }}</td></tr>
        <tr><th>Room</th><td>{{ $appointment->examination_room }}</td></tr>
    </table>
    <div style="margin-top:1rem">
        <form method="POST" action="{{ route('appointments.destroy', $appointment->appointment_id) }}" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel appointment</button>
        </form>
    </div>
</div>
@endsection
