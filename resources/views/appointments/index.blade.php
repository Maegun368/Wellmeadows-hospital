@extends('layouts.app')
@section('title', 'Appointments')
@section('topbar-actions')
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">+ New appointment</a>
@endsection
@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">
    <a href="{{ route('patient-medications.index') }}" style="text-decoration:none">
        <div class="card" style="display:flex;align-items:center;gap:12px;cursor:pointer">
            <span style="font-size:28px">💊</span>
            <div>
                <div style="font-weight:600;color:#1a3a5c">Patient Medications</div>
                <div style="font-size:12px;color:#718096">View & manage prescriptions</div>
            </div>
        </div>
    </a>
    <a href="{{ route('pharmaceuticals.index') }}" style="text-decoration:none">
        <div class="card" style="display:flex;align-items:center;gap:12px;cursor:pointer">
            <span style="font-size:28px">🧪</span>
            <div>
                <div style="font-weight:600;color:#1a3a5c">Pharmaceuticals</div>
                <div style="font-size:12px;color:#718096">View & manage drug inventory</div>
            </div>
        </div>
    </a>
</div>
<div class="card">
    <div style="display:flex;gap:8px;margin-bottom:1rem">
        <input type="text" placeholder="Search patient..." style="padding:8px 12px;border-radius:8px;border:1px solid #cbd5e0;font-size:13px;flex:1">
        <select style="padding:8px 12px;border-radius:8px;border:1px solid #cbd5e0;font-size:13px">
            <option>All dates</option><option>Today</option><option>This week</option>
        </select>
    </div>
    <table>
        <thead>
            <tr>
                <th>Patient ID</th><th>Consultant</th><th>Date</th><th>Time</th><th>Room</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appt)
            <tr>
                <td>{{ $appt->patient_id }}</td>
                <td>{{ $appt->consultant_id }}</td>
                <td>{{ $appt->appointment_date }}</td>
                <td>{{ $appt->appointment_time }}</td>
                <td>{{ $appt->examination_room }}</td>
                <td style="display:flex;gap:6px">
                    <a href="{{ route('appointments.show', $appt->appointment_id) }}" class="btn">View</a>
                    <a href="{{ route('appointments.edit', $appt->appointment_id) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('appointments.destroy', $appt->appointment_id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#718096;padding:2rem">No appointments found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $appointments->links() }}</div>
</div>
@endsection
