@extends('layouts.app')
@section('title', 'Update Medication')
@section('topbar-actions')
    <a href="{{ route('patient-medications.index') }}" class="btn">Back</a>
@endsection
@section('content')
<div class="card" style="max-width:640px; margin: 2rem auto;">
    <div class="card-title">Update medication #{{ $medication->medication_id }}</div>
    <form method="POST" action="{{ route('patient-medications.update', $medication->medication_id) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Patient</label>
                <select name="patient_id" required>
                    <option value="">— Select patient —</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" @selected(old('patient_id', $medication->patient_id) == $patient->id)>
                            {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->id }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Drug</label>
                <select name="drug_no" required>
                    <option value="">— Select drug —</option>
                    @foreach($pharmaceuticals as $drug)
                        <option value="{{ $drug->drug_no }}" @selected(old('drug_no', $medication->drug_no) == $drug->drug_no)>
                            {{ $drug->drug_name }} - {{ $drug->dosage }} (ID {{ $drug->drug_no }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Method of administration</label>
                <input type="text" name="method_of_admin" value="{{ old('method_of_admin', $medication->method_of_admin) }}" required>
            </div>
            <div class="form-group">
                <label>Units per day</label>
                <input type="number" name="units_per_day" value="{{ old('units_per_day', $medication->units_per_day) }}" required>
            </div>
            <div class="form-group">
                <label>Start date</label>
                <input type="date" name="start_date" value="{{ old('start_date', $medication->start_date) }}" required>
            </div>
            <div class="form-group">
                <label>Finish date</label>
                <input type="date" name="finish_date" value="{{ old('finish_date', $medication->finish_date) }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
