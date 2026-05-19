@extends('layouts.app')
@section('title', 'Add User')

@section('content')

<style>
:root {
    --blue-dark:  #1a5276;
    --blue-mid:   #2e86c1;
    --blue-pale:  #d6eaf8;
    --blue-bg:    #e8f4fd;
    --white:      #ffffff;
}

.form-topbar {
    background: var(--blue-dark);
    padding: 14px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.form-topbar h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.btn-back {
    background: transparent;
    color: rgba(255,255,255,0.8);
    border: 1px solid rgba(255,255,255,0.4);
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 13px;
    text-decoration: none;
    transition: background .15s;
}
.btn-back:hover { background: rgba(255,255,255,0.1); color: var(--white); }

.form-body {
    padding: 24px;
    background: var(--blue-bg);
    min-height: calc(100vh - 60px);
    display: flex;
    justify-content: center;
}

.form-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
    width: 100%;
    max-width: 560px;
    height: fit-content;
}
.form-card-header {
    background: var(--blue-mid);
    padding: 10px 20px;
    font-size: 12px;
    font-weight: 700;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.form-card-body { padding: 24px; }

.form-group { margin-bottom: 18px; }
.form-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: var(--blue-dark);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 6px;
}
.form-input {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--blue-pale);
    border-radius: 8px;
    font-size: 13px;
    color: #2d3748;
    background: #f9fcff;
    box-sizing: border-box;
    transition: border-color .15s;
}
.form-input:focus {
    outline: none;
    border-color: var(--blue-mid);
    background: var(--white);
}
.form-select {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--blue-pale);
    border-radius: 8px;
    font-size: 13px;
    color: #2d3748;
    background: #f9fcff;
    box-sizing: border-box;
    cursor: pointer;
}
.form-select:focus { outline: none; border-color: var(--blue-mid); }

.form-error { font-size: 11px; color: #c0392b; margin-top: 4px; }

.role-desc {
    font-size: 11px;
    color: #718096;
    margin-top: 6px;
    padding: 8px 12px;
    background: #f0f8ff;
    border-radius: 6px;
    border-left: 3px solid var(--blue-mid);
    display: none;
}

.btn-submit {
    width: 100%;
    background: var(--blue-dark);
    color: var(--white);
    border: none;
    padding: 11px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: opacity .15s;
    margin-top: 8px;
}
.btn-submit:hover { opacity: 0.9; }

.divider {
    border: none;
    border-top: 1px solid var(--blue-pale);
    margin: 20px 0;
}
</style>

{{-- Top bar --}}
<div class="form-topbar">
    <h2>Add New User</h2>
    <a href="{{ route('users.index') }}" class="btn-back">← Back</a>
</div>

{{-- Body --}}
<div class="form-body">
    <div class="form-card">
        <div class="form-card-header">User Details</div>
        <div class="form-card-body">

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input"
                           value="{{ old('name') }}" placeholder="e.g. Moira Samuel" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input"
                           value="{{ old('email') }}" placeholder="e.g. moira@wellmeadows.com" required>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="divider">

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input"
                           placeholder="Min. 8 characters" required>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input"
                           placeholder="Repeat password" required>
                </div>

                <hr class="divider">

                {{-- Role --}}
                <div class="form-group">
                    <label class="form-label">Assign Role</label>
                    <select name="role" class="form-select" onchange="showRoleDesc(this.value)" required>
                        <option value="">— Select a role —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ match($role->name) {
                                    'medical_director'  => 'Medical Director',
                                    'personnel_officer' => 'Personnel Officer',
                                    'charge_nurse'      => 'Charge Nurse',
                                    default             => $role->name,
                                } }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="form-error">{{ $message }}</div>
                    @enderror

                    <div class="role-desc" id="desc-medical_director">
                        👁️ <strong>View-only</strong> access across all modules. Cannot create, edit, or delete records.
                    </div>
                    <div class="role-desc" id="desc-personnel_officer">
                        👤 <strong>Full control over Staff</strong> module only. Can view Dashboard and Wards. No access to Patients, Appointments, or Medications.
                    </div>
                    <div class="role-desc" id="desc-charge_nurse">
                        ✅ <strong>Full clinical access</strong> — manages Patients, Appointments, Wards, Medications, and Pharmaceuticals. View-only on Staff.
                    </div>
                </div>

                <button type="submit" class="btn-submit">Create User</button>
            </form>

        </div>
    </div>
</div>

<script>
function showRoleDesc(role) {
    document.querySelectorAll('.role-desc').forEach(el => el.style.display = 'none');
    if (role) {
        const el = document.getElementById('desc-' + role);
        if (el) el.style.display = 'block';
    }
}
// Show on page load if old value exists
showRoleDesc('{{ old('role') }}');
</script>

@endsection