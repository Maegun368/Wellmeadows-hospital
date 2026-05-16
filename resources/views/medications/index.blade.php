@extends('layouts.app')
@section('title', 'Patient Medications')

@section('content')   {{-- ← only ONE of these --}}

<div style="padding:14px 24px; display:flex; gap:8px;">
    <a href="{{ route('appointments.index') }}" class="btn">← Back to Appointments</a>
    <a href="{{ route('patient-medications.create') }}" class="btn btn-primary">+ Prescribe medication</a>
</div>
@if(session('success'))
    <div style="margin:1rem 1.5rem;padding:12px 16px;background:#c6f6d5;border:1px solid #68d391;border-radius:6px;color:#22543d;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Drug No</th>
                <th>Drug Name</th>
                <th>Description</th>
                <th>Dosage</th>
                <th>Method</th>
                <th>Units/Day</th>
                <th>Start</th>
                <th>Finish</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medications as $med)
            <tr>
                <td>{{ $med->medication_id }}</td>
                <td>
                    {{ $med->patient->last_name ?? '' }}, {{ $med->patient->first_name ?? '—' }}
                    <br><small style="color:#718096;">#{{ $med->patient_id }}</small>
                </td>
                <td>{{ $med->drug_no }}</td>
                <td>{{ $med->pharmaceutical->drug_name ?? '—' }}</td>
                <td>{{ $med->drug_description ?? '—' }}</td>
                <td>{{ $med->dosage ?? '—' }}</td>
                <td>{{ $med->method_of_admin }}</td>
                <td>{{ $med->units_per_day }}</td>
                <td>{{ \Carbon\Carbon::parse($med->start_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($med->finish_date)->format('d M Y') }}</td>
                <td style="display:flex; gap:6px;">
                    <a href="{{ route('patient-medications.edit', $med->medication_id) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('patient-medications.destroy', $med->medication_id) }}"
                          style="margin:0" onsubmit="return confirm('Delete this prescription?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center;color:#718096;padding:2rem">No medications prescribed.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $medications->links() }}</div>
</div>
@endsection