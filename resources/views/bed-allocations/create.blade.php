@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <div class="card" style="max-width:640px; margin:0 auto;">

        <h2 class="card-title">Assign Bed</h2>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left:1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bed-allocations.store') }}">
            @csrf

            <div class="form-group">
                <label>Patient</label>
                <select name="patient_id" required>
                    <option value="">— Select patient —</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" @selected(old('patient_id', request('patient_id')) == $patient->id)>
                            {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ward</label>
                <select name="ward_id" required>
                    <option value="">— Select ward —</option>
                    @foreach($wards as $ward)
                        <option value="{{ $ward->ward_id }}" @selected(old('ward_id') == $ward->ward_id)>
                            {{ $ward->ward_name }} — {{ $ward->location }} ({{ $ward->total_beds }} beds)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Bed Number</label>
                <input type="number" name="bed_number" min="1" value="{{ old('bed_number') }}" required>
            </div>

            <div class="form-group">
                <label>Expected Leave Date (optional)</label>
                <input type="date" name="date_expected_leave" value="{{ old('date_expected_leave') }}">
            </div>

            <div style="display:flex; gap:10px; margin-top:1rem;">
                <button type="submit" class="btn btn-primary">Save Assignment</button>
                <a href="{{ route('bed-allocations.index') }}" class="btn">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection