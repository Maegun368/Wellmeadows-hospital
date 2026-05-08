@extends('layouts.app')

@section('title', isset($medication) ? 'Edit Medication' : 'Prescribe Medication')

@section('content')
<div class="card" style="max-width:640px;">
    <div class="card-header">
        <span class="card-title">{{ isset($medication) ? 'Update prescription' : 'Prescribe medication' }}</span>
    </div>

    <form method="POST" action="{{ isset($medication) ? route('medications.update', $medication->medication_id) : route('medications.store') }}">
        @csrf
        @if(isset($medication)) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Patient ID</label>
                <input type="number" name="patient_id" class="form-control"
                    value="{{ old('patient_id', $medication->patient_id ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Drug no</label>
                <input type="number" name="drug_no" class="form-control"
                    value="{{ old('drug_no', $medication->drug_no ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Method of administration</label>
                <input type="text" name="method_of_admin" class="form-control"
                    value="{{ old('method_of_admin', $medication->method_of_admin ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Units per day</label>
                <input type="number" name="units_per_day" class="form-control"
                    value="{{ old('units_per_day', $medication->units_per_day ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Start date</label>
                <input type="date" name="start_date" class="form-control"
                    value="{{ old('start_date', $medication->start_date ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Finish date</label>
                <input type="date" name="finish_date" class="form-control"
                    value="{{ old('finish_date', $medication->finish_date ?? '') }}" required>
            </div>
        </div>

        <div style="display:flex; gap:8px; margin-top:1rem;">
            <button type="submit" class="btn btn-primary">{{ isset($medication) ? 'Save changes' : 'Prescribe' }}</button>
            <a href="{{ route('medications.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>
@endsection
