@extends('layouts.app')
@section('title', 'Add Staff')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-pale:   #d6eaf8;
    --blue-bg:     #e8f4fd;
    --white:       #ffffff;
}
.create-wrapper {
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: var(--blue-bg);
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
}
.card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0;
}
.card-sub { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 2px; }
.create-card-body { padding: 24px; }
.section-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--blue-mid);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid var(--blue-pale);
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
    font-family: inherit;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--blue-dark);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(41,128,185,0.15);
}
.field-error { color: #e74c3c; font-size: 11px; margin-top: 4px; display: block; }
.spacer { height: 8px; }
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
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.btn-save:hover { background: var(--blue-mid); }
.btn-cancel {
    background: var(--white);
    color: #e74c3c;
    border: 1px solid #e74c3c;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: inline-flex;
    align-items: center;
}
.btn-cancel:hover { background: #fadbd8; }
</style>

<div class="create-wrapper">
    <div class="create-card">

        <div class="create-card-header">
            <div class="card-title">Add Staff Member</div>
            <div class="card-sub">Fill in the details to register a new staff member</div>
        </div>

        <div class="create-card-body">

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div style="background:#fadbd8; border:1px solid #e74c3c; border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:13px; color:#c0392b;">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin:6px 0 0 16px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('staff.store') }}">
                @csrf

                {{-- Personal Info --}}
                <div class="section-label">Personal Information</div>
                <div class="form-grid-3">
                    <div class="form-group">
                        <label>First Name <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                        @error('first_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                        @error('last_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Date of Birth <span style="color:#e74c3c">*</span></label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        {{-- Controller expects 'sex', not 'gender' --}}
                        <label>Sex <span style="color:#e74c3c">*</span></label>
                        <select name="sex" required>
                            <option value="">— Select —</option>
                            <option value="Male"   {{ old('sex') === 'Male'   ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other"  {{ old('sex') === 'Other'  ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('sex')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        {{-- Controller expects 'phone', not 'telephone_number' --}}
                        <label>Phone <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+63 9XX XXX XXXX" required>
                        @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>NIN <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="NIN" value="{{ old('NIN') }}" placeholder="National ID No." required>
                        @error('NIN')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Address <span style="color:#e74c3c">*</span></label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, City" required>
                    @error('address')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="spacer"></div>

                {{-- Professional Info --}}
                <div class="section-label">Professional Details</div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Position / Role <span style="color:#e74c3c">*</span></label>
                        <select name="position" required>
                            <option value="">— Select —</option>
                            <option value="Doctor"      {{ old('position') === 'Doctor'      ? 'selected' : '' }}>Doctor</option>
                            <option value="Consultant"  {{ old('position') === 'Consultant'  ? 'selected' : '' }}>Consultant</option>
                            <option value="Nurse"       {{ old('position') === 'Nurse'       ? 'selected' : '' }}>Nurse</option>
                            <option value="Head Nurse"  {{ old('position') === 'Head Nurse'  ? 'selected' : '' }}>Head Nurse</option>
                            <option value="Admin"       {{ old('position') === 'Admin'       ? 'selected' : '' }}>Admin</option>
                            <option value="Pharmacist"  {{ old('position') === 'Pharmacist'  ? 'selected' : '' }}>Pharmacist</option>
                            <option value="Technician"  {{ old('position') === 'Technician'  ? 'selected' : '' }}>Technician</option>
                        </select>
                        @error('position')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Contract Type <span style="color:#e74c3c">*</span></label>
                        <select name="contract_type" required>
                            <option value="">— Select —</option>
                            <option value="Full-time" {{ old('contract_type') === 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('contract_type') === 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        </select>
                        @error('contract_type')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        {{-- Controller expects 'current_salary', not 'salary' --}}
                        <label>Salary (₱) <span style="color:#e74c3c">*</span></label>
                        <input type="number" name="current_salary" value="{{ old('current_salary') }}" placeholder="e.g. 35000" step="0.01" required>
                        @error('current_salary')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Pay Type <span style="color:#e74c3c">*</span></label>
                        <select name="pay_type" required>
                            <option value="">— Select —</option>
                            <option value="Monthly" {{ old('pay_type') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Weekly"  {{ old('pay_type') === 'Weekly'  ? 'selected' : '' }}>Weekly</option>
                        </select>
                        @error('pay_type')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Hours / Week <span style="color:#e74c3c">*</span></label>
                        <input type="number" name="hours_per_week" value="{{ old('hours_per_week') }}" placeholder="e.g. 40" min="1" max="84" required>
                        @error('hours_per_week')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Salary Scale <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="salary_scale" value="{{ old('salary_scale') }}" placeholder="e.g. Scale 4" required>
                        @error('salary_scale')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Ward Assignment</label>
                        <select name="ward_id">
                            <option value="">— No ward —</option>
                            @foreach($wards as $ward)
                            <option value="{{ $ward->ward_id }}" {{ old('ward_id') == $ward->ward_id ? 'selected' : '' }}>
                                {{ $ward->ward_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('ward_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Save Staff Member</button>
                    <a href="{{ route('staff.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection