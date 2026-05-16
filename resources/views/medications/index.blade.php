@extends('layouts.app')
@section('title', 'Patient Medications')

@section('topbar-actions')
    <a href="{{ route('appointments.index') }}" class="btn">Back to Appointments</a>
    <a href="{{ route('patient-medications.create') }}" class="btn btn-primary">+ Prescribe medication</a>
@endsection

@section('content')

<div style="padding:14px 24px; display:flex; gap:8px;">
    <a href="{{ route('appointments.index') }}" class="btn">Back to Appointments</a>
    <a href="{{ route('patient-medications.create') }}" class="btn btn-primary">+ Prescribe medication</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr><th>ID</th><th>Patient ID</th><th>Drug No</th><th>Method</th><th>Units/Day</th><th>Start</th><th>Finish</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($medications as $med)
            <tr>
                <td>{{ $med->medication_id }}</td>
                <td>{{ $med->patient_id }}</td>
                <td>{{ $med->drug_no }}</td>
                <td>{{ $med->method_of_admin }}</td>
                <td>{{ $med->units_per_day }}</td>
                <td>{{ $med->start_date }}</td>
                <td>{{ $med->finish_date }}</td>
               <td style="display:flex; gap:6px;">
    <a href="{{ route('patient-medications.edit', $med->medication_id) }}" class="btn">Edit</a>
    <form method="POST" action="{{ route('patient-medications.destroy', $med->medication_id) }}" style="margin:0"
          onsubmit="return confirm('Delete this prescription?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#718096;padding:2rem">No medications prescribed.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $medications->links() }}</div>
</div>
@endsection