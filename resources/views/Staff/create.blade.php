@extends('layouts.app')

@section('title', 'Add New Staff')

@section('topbar-actions')
    <a href="{{ route('staff.index') }}" class="btn">← Back to Staff</a>
@endsection

@section('content')

<div class="card">
    <div class="card-title">New Staff Member</div>

    <form action="{{ route('staff.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                @error('first_name')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Sex</label>
                <select name="sex" required>
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('sex')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required>
                @error('phone')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>NIN</label>
                <input type="text" name="NIN" value="{{ old('NIN') }}" required>
                @error('NIN')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="2" required>{{ old('address') }}</textarea>
            @error('address')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" value="{{ old('position') }}" required>
                @error('position')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Contract Type</label>
                <select name="contract_type" required>
                    <option value="">-- Select --</option>
                    <option value="Full-time" {{ old('contract_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ old('contract_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                </select>
                @error('contract_type')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Current Salary (£)</label>
                <input type="number" step="0.01" name="current_salary" value="{{ old('current_salary') }}" required>
                @error('current_salary')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Salary Scale</label>
                <input type="text" name="salary_scale" value="{{ old('salary_scale') }}" required>
                @error('salary_scale')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Hours Per Week</label>
                <input type="number" name="hours_per_week" value="{{ old('hours_per_week') }}" required>
                @error('hours_per_week')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Pay Type</label>
                <select name="pay_type" required>
                    <option value="">-- Select --</option>
                    <option value="Monthly" {{ old('pay_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Weekly" {{ old('pay_type') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                </select>
                @error('pay_type')<p style="color:red;font-size:12px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div style="display:flex; gap:1rem; margin-top:1rem;">
            <button type="submit" class="btn btn-primary">Save Staff Member</button>
            <a href="{{ route('staff.index') }}" class="btn">Cancel</a>
        </div>

    </form>
</div>

@endsection