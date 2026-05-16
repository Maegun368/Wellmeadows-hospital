@extends('layouts.app')

@section('title', 'Update Patient')

@section('topbar-actions')
    <a href="{{ route('patients.index') }}" class="btn">Back to Patients</a>
@endsection

@section('content')

<div class="card">
    <div class="card-title">Update Patient</div>

    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                @error('first_name')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                @error('last_name')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" value="{{ old('age', $patient->age) }}" required>
                @error('age')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $patient->contact_number) }}" required>
                @error('contact_number')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Blood Type</label>
                <select name="blood_type">
                    <option value="">-- Select --</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                        <option value="{{ $type }}" {{ old('blood_type', $patient->blood_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @error('blood_type')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="2" required>{{ old('address', $patient->address) }}</textarea>
            @error('address')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Ward</label>
                <input type="text" name="ward" value="{{ old('ward', $patient->ward) }}">
                @error('ward')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Bed Number</label>
                <input type="text" name="bed_number" value="{{ old('bed_number', $patient->bed_number) }}">
                @error('bed_number')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Admission Date</label>
            <input type="date" name="admission_date" value="{{ old('admission_date', $patient->admission_date) }}">
            @error('admission_date')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Medical Record</label>
            <textarea name="medical_record" rows="3">{{ old('medical_record', $patient->medical_record) }}</textarea>
            @error('medical_record')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex; gap:1rem; margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Update Patient</button>
            <a href="{{ route('patients.index') }}" class="btn">Cancel</a>
        </div>

    </form>
</div>

@endsection