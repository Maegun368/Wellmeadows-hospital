@extends('layouts.app')
@section('title', 'New Patient')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-accent: #2980b9;
    --blue-pale:   #d6eaf8;
    --white:       #ffffff;
}

.create-wrapper {
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: #e8f4fd;
}

.create-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    width: 100%;
    max-width: 750px;
    overflow: hidden;
}

.create-card-header {
    background: var(--blue-dark);
    padding: 16px 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.create-card-header .card-icon {
    background: rgba(255,255,255,0.15);
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.create-card-header .card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.create-card-header .card-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
}

.create-card-body {
    padding: 24px;
}

.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

.form-group { margin-bottom: 1rem; }

.form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid var(--blue-light);
    font-size: 13px;
    color: #2d3748;
    background: #f0f8ff;
    transition: border-color .15s, box-shadow .15s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--blue-dark);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(41,128,185,0.15);
}

.form-group textarea { resize: vertical; min-height: 70px; }

.field-error { color: #e74c3c; font-size: 11px; margin-top: 4px; display: block; }

.spacer { height: 4px; }

.form-actions {
    display: flex;
    gap: 10px;
    padding-top: 16px;
    border-top: 1px solid var(--blue-pale);
    margin-top: 8px;
}

.btn-save {
    background: var(--blue-dark);
    color: var(--white);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    letter-spacing: 0.04em;
    transition: background .15s;
}

.btn-save:hover { background: var(--blue-mid); }

.btn-cancel {
    background: var(--white);
    color: #e74c3c;
    border: 1px solid #e74c3c;
    padding: 10px 24px;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    letter-spacing: 0.04em;
    transition: background .15s;
    display: inline-flex;
    align-items: center;
}

.btn-cancel:hover { background: #fadbd8; }
</style>

<div class="create-wrapper">
    <div class="create-card">

        <div class="create-card-header">
    <div class="card-icon">👤</div>
    <div>
        <div class="card-title">Register New Patient</div>
        <div class="card-sub">Fill in the details to add a patient record</div>
    </div>
        </div>

        <div class="create-card-body">
            <form method="POST" action="{{ route('patients.store') }}">
                @csrf

                {{-- Personal Information --}}
                <div class="section-label">Personal Information</div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                        @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                        @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Sex</label>
                        <select name="sex" required>
                            <option value="">— Select —</option>
                            <option value="Male"   {{ old('sex') === 'Male'   ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other"  {{ old('sex') === 'Other'  ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('sex')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Marital Status</label>
                        <select name="marital_status">
                            <option value="">— Select —</option>
                            <option value="Single"   {{ old('marital_status') === 'Single'   ? 'selected' : '' }}>Single</option>
                            <option value="Married"  {{ old('marital_status') === 'Married'  ? 'selected' : '' }}>Married</option>
                            <option value="Widowed"  {{ old('marital_status') === 'Widowed'  ? 'selected' : '' }}>Widowed</option>
                            <option value="Divorced" {{ old('marital_status') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        </select>
                        @error('marital_status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, City, Province">
                    @error('address')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+63 9XX XXX XXXX">
                        @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Date of Registration</label>
                        <input type="date" name="date_of_registration"
                               value="{{ old('date_of_registration', now()->format('Y-m-d')) }}">
                        @error('date_of_registration')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="spacer"></div>

                {{-- Medical Information --}}
                <div class="section-label">Medical Information</div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Ward / Department</label>
                        <input type="text" name="ward" value="{{ old('ward') }}" placeholder="e.g. ICU, General">
                        @error('ward')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Admission Date</label>
                        <input type="date" name="admission_date" value="{{ old('admission_date') }}">
                        @error('admission_date')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Doctor / Consultant</label>
                    <select name="doctor" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid var(--blue-light); font-size: 13px; color: #2d3748; background: #f0f8ff;">
                        <option value="">— Select a doctor —</option>
                        @foreach($doctors as $id => $fullName)
                            <option value="{{ $fullName }}" {{ old('doctor') == $fullName ? 'selected' : '' }}>
                                {{ $fullName }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="spacer"></div>

                {{-- Next of Kin --}}
                <div class="section-label">Next of Kin</div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="kin_name" value="{{ old('kin_name') }}" placeholder="Full name">
                        @error('kin_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="kin_relationship" value="{{ old('kin_relationship') }}" placeholder="e.g. Spouse">
                        @error('kin_relationship')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="kin_phone" value="{{ old('kin_phone') }}" placeholder="+63 9XX XXX XXXX">
                        @error('kin_phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Register Patient</button>
                    <a href="{{ route('patients.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection