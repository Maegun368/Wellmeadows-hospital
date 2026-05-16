@extends('layouts.app')
@section('title', 'Prescribe Medication')
@section('topbar-actions')
    <a href="{{ route('patient-medications.index') }}" class="btn">Back</a>
@endsection
@section('content')

<script>
    const drugData = {
        @foreach($pharmaceuticals as $drug)
            "{{ $drug->drug_no }}": {
                description: "{{ addslashes($drug->drug_description ?? '') }}",
                dosage: "{{ addslashes($drug->dosage ?? '') }}"
            },
        @endforeach
    };

    function onDrugChange(select) {
        const selected = drugData[select.value] || { description: '', dosage: '' };
        document.getElementById('drug_description').value = selected.description;
        document.getElementById('dosage').value = selected.dosage;
    }
</script>

<div class="card" style="max-width:640px; margin: 2rem auto;">
    <div class="card-title">Prescribe medication</div>

    @if($errors->any())
        <div style="background:#fed7d7;border:1px solid #fc8181;border-radius:6px;padding:12px 16px;margin-bottom:1rem;color:#742a2a;">
            <ul style="margin:0;padding-left:1.2rem;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('patient-medications.store') }}">
        @csrf
        <div class="form-grid">

            <div class="form-group">
                <label>Patient</label>
                <select name="patient_id" required>
                    <option value="">— Select patient —</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->patient_id }}" @selected(old('patient_id') == $patient->patient_id)>
                            {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->patient_id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Drug</label>
                <select name="drug_no" required onchange="onDrugChange(this)">
                    <option value="">— Select drug —</option>
                    @foreach($pharmaceuticals as $drug)
                        <option value="{{ $drug->drug_no }}" @selected(old('drug_no') == $drug->drug_no)>
                            {{ $drug->drug_name }} (ID {{ $drug->drug_no }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" id="drug_description" name="drug_description"
                    value="{{ old('drug_description') }}"
                    placeholder="Auto-filled when drug is selected">
            </div>

            <div class="form-group">
                <label>Dosage</label>
                <input type="text" id="dosage" name="dosage"
                    value="{{ old('dosage') }}"
                    placeholder="e.g. 10mg/ml">
            </div>

            <div class="form-group">
                <label>Method of administration</label>
                <input type="text" name="method_of_admin" value="{{ old('method_of_admin') }}" required>
            </div>

            <div class="form-group">
                <label>Units per day</label>
                <input type="number" name="units_per_day" value="{{ old('units_per_day') }}" min="1" required>
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
        <a href="{{ route('patient-medications.index') }}" class="btn">Cancel</a>
    </form>
</div>
@endsection