@extends('layouts.app')
@section('title', 'Patient Medications')
@section('topbar-actions')
    <a href="{{ route('patient-medications.create') }}" class="btn btn-primary">+ Prescribe medication</a>
@endsection
@section('content')
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
                <td><a href="{{ route('patient-medications.edit', $med->medication_id) }}" class="btn">Edit</a></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#718096;padding:2rem">No medications prescribed.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $medications->links() }}</div>
</div>
@endsection
