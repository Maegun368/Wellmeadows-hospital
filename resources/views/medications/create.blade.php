@extends('layouts.app')
@section('title', 'Prescribe Medication')
@section('topbar-actions')
    <a href="{{ route('patient-medications.index') }}" class="btn">← Back</a>
@endsection
@section('content')
<div class="card" style="max-width:640px">
    <div class="card-title">Prescribe medication</div>
    <form method="POST" action="{{ route('patient-medications.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Patient ID</label>
                <input type="number" name="patient_id" value="{{ old('patient_id') }}" required>
            </div>
            <div class="form-group">
                <label>Drug No</label>
                <input type="number" name="drug_no" value="{{ old('drug_no') }}" required>
            </div>
            <div class="form-group">
                <label>Method of administration</label>
                <input type="text" name="method_of_admin" value="{{ old('method_of_admin') }}" required>
            </div>
            <div class="form-group">
                <label>Units per day</label>
                <input type="number" name="units_per_day" value="{{ old('units_per_day') }}" required>
            </div>
            <div class="form-group">
                <label>Start date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required>
            </div>
            <div class="form-group">
                <label>Finish date</label>
                <input type="date" name="finish_date" value="{{ old('finish_date') }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Prescribe</button>
    </form>
</div>
@endsection
