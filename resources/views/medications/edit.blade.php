@extends('layouts.app')
@section('title', 'Update Medication')
@section('topbar-actions')
    <a href="{{ route('patient-medications.index') }}" class="btn">Back</a>
@endsection
@section('content')
<div class="card" style="max-width:640px; margin: 2rem auto;">
    <div class="card-title">Update medication #{{ $medication->medication_id }}</div>

    @if($errors->any())
        <div style="background:#fed7d7;border:1px solid #fc8181;border-radius:6px;padding:12px 16px;margin-bottom:1rem;color:#742a2a;">
            <ul style="margin:0;padding-left:1.2rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('patient-medications.update', $medication->medication_id) }}">
        @csrf @method('PUT')
        <div class="form-grid">

            {{-- Patient & Drug are read-only on edit --}}
            <div class="form-group">
                <label>Patient</label>
                <input type="text" disabled
                    value="{{ $medication->patient->last_name ?? '' }}, {{ $medication->patient->first_name ?? '' }} (ID {{ $medication->patient_id }})">
            </div>

            <div class="form-group">
                <label>Drug</label>
                <input type="text" disabled
                    value="{{ $medication->pharmaceutical->drug_name ?? '' }} (ID {{ $medication->drug_no }})">
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" name="drug_description"
                    value="{{ old('drug_description', $medication->drug_description) }}"
                    placeholder="e.g. Pain killer">
            </div>

            <div class="form-group">
                <label>Dosage</label>
                <input type="text" name="dosage"
                    value="{{ old('dosage', $medication->dosage) }}"
                    placeholder="e.g. 10mg/ml">
            </div>

            <div class="form-group">
                <label>Method of administration</label>
                <input type="text" name="method_of_admin"
                    value="{{ old('method_of_admin', $medication->method_of_admin) }}" required>
            </div>

            <div class="form-group">
                <label>Units per day</label>
                <input type="number" name="units_per_day"
                    value="{{ old('units_per_day', $medication->units_per_day) }}" min="1" required>
            </div>

            <div class="form-group">
                <label>Start date</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', $medication->start_date) }}" required>
            </div>

            <div class="form-group">
                <label>Finish date</label>
                <input type="date" name="finish_date"
                    value="{{ old('finish_date', $medication->finish_date) }}" required>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection