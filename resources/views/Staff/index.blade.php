@extends('layouts.app')
@section('title', 'Staff')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-accent: #2980b9;
    --blue-pale:   #d6eaf8;
    --blue-bg:     #e8f4fd;
    --white:       #ffffff;
}

/* ── Top bar ── */
.staff-topbar {
    background: var(--blue-dark);
    padding: 14px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.staff-topbar h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.staff-topbar-sub { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 2px; }
.staff-topbar-right { display: flex; gap: 10px; align-items: center; }

.topbar-search {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
    color: var(--white);
    width: 220px;
}
.topbar-search::placeholder { color: rgba(255,255,255,0.5); }
.topbar-search:focus { outline: none; background: rgba(255,255,255,0.2); }

.btn-add {
    background: var(--white);
    color: var(--blue-dark);
    border: none;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity .15s;
    white-space: nowrap;
}
.btn-add:hover { opacity: 0.9; }

/* ── Stat cards row ── */
.stat-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    padding: 20px 24px 0;
    background: var(--blue-bg);
}
.stat-card {
    background: var(--blue-mid);
    border-radius: 10px;
    padding: 18px 20px;
    color: var(--white);
}
.stat-card.dark { background: var(--blue-dark); }
.stat-card.accent { background: var(--blue-accent); }
.stat-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: rgba(255,255,255,0.7);
    margin-bottom: 8px;
}
.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: var(--white);
    line-height: 1;
}
.stat-sub { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 6px; }

/* ── Main body ── */
.staff-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 20px 24px;
    background: var(--blue-bg);
    min-height: calc(100vh - 200px);
    align-items: start;
}

/* ── Left: Staff list ── */
.panel {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
}
.panel-header {
    background: var(--blue-mid);
    padding: 10px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.panel-title {
    font-size: 12px;
    font-weight: 700;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.panel-link {
    font-size: 12px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
}
.panel-link:hover { color: var(--white); }

/* Staff table */
.staff-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.staff-table th {
    text-align: left;
    padding: 9px 14px;
    background: #f0f8ff;
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid var(--blue-pale);
}
.staff-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #f0f8ff;
    color: #2d3748;
    vertical-align: middle;
}
.staff-table tr:last-child td { border-bottom: none; }
.staff-table tr:hover td { background: #f0f8ff; }

.staff-avatar {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: var(--blue-mid);
    color: var(--white);
    font-size: 11px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.staff-name-cell { display: flex; align-items: center; gap: 8px; }
.staff-name { font-weight: 600; color: var(--blue-dark); }
.staff-email { font-size: 11px; color: #718096; }

.role-badge {
    display: inline-block;
    font-size: 10px;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 600;
}
.role-doctor  { background: var(--blue-pale); color: var(--blue-dark); }
.role-nurse   { background: #d5f5e3; color: #1e8449; }
.role-admin   { background: #fdebd0; color: #935116; }
.role-other   { background: #f2f3f4; color: #566573; }

.tbl-btn {
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid var(--blue-mid);
    background: var(--white);
    color: var(--blue-dark);
    cursor: pointer;
    text-decoration: none;
    font-weight: 500;
    transition: background .15s;
    display: inline-block;
}
.tbl-btn:hover { background: var(--blue-pale); }
.tbl-btn-danger { border-color: #e74c3c; color: #c0392b; }
.tbl-btn-danger:hover { background: #fadbd8; }

.panel-pagination {
    padding: 10px 14px;
    border-top: 1px solid var(--blue-pale);
    display: flex;
    justify-content: flex-end;
    background: #f9fcff;
}

/* ── Right panel ── */
.right-col { display: flex; flex-direction: column; gap: 16px; }

/* Appointments list */
.appt-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    border-bottom: 1px solid #f0f8ff;
    font-size: 13px;
}
.appt-item:last-child { border-bottom: none; }
.appt-name { font-weight: 600; color: var(--blue-dark); }
.appt-sub  { font-size: 11px; color: var(--blue-light); margin-top: 2px; }
.appt-time { font-size: 12px; font-weight: 600; color: var(--blue-accent); }

/* Ward occupancy list */
.ward-item {
    padding: 8px 14px;
    border-bottom: 1px solid #f0f8ff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
}
.ward-item:last-child { border-bottom: none; }
.ward-name { font-weight: 600; color: var(--blue-dark); font-size: 12px; }
.ward-bar-wrap { flex: 1; margin: 0 12px; height: 6px; background: var(--blue-pale); border-radius: 99px; }
.ward-bar { height: 6px; border-radius: 99px; background: var(--blue-mid); }
.ward-count { font-size: 11px; color: var(--blue-mid); font-weight: 600; white-space: nowrap; }

</style>

{{-- ── Top bar ── --}}
<div class="staff-topbar">
    <div>
        <h2>Staff Management</h2>
        <div class="staff-topbar-sub">{{ now()->format('F d, Y | h:i A') }}</div>
    </div>
    <div class="staff-topbar-right">
        <input type="text" class="topbar-search" id="staffSearch"
               placeholder="Search staff..." oninput="filterStaff(this.value)">
        <a href="{{ route('staff.create') }}" class="btn-add">+ Add Staff</a>
    </div>
</div>

{{-- ── Stat cards ── --}}
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-label">Total Staff</div>
        <div class="stat-value">{{ $totalStaff }}</div>
        <div class="stat-sub">All departments</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-label">Doctors</div>
        <div class="stat-value">{{ $totalDoctors }}</div>
        <div class="stat-sub">Active consultants</div>
    </div>
    <div class="stat-card accent">
        <div class="stat-label">Nurses</div>
        <div class="stat-value">{{ $totalNurses }}</div>
        <div class="stat-sub">On duty</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-label">Wards</div>
        <div class="stat-value">{{ $totalWards }}</div>
        <div class="stat-sub">Active wards</div>
    </div>
</div>

{{-- ── Main body ── --}}
<div class="staff-body">

    {{-- Left: Staff list --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Staff List</span>
        </div>

        <table class="staff-table" id="staffTable">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Ward</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                @php
                    $initials = strtoupper(substr($member->first_name ?? $member->name ?? 'S', 0, 1) .
                                substr($member->last_name ?? '', 0, 1));
                    $role = strtolower($member->position ?? $member->role ?? '');
                    $roleClass = str_contains($role, 'doctor') || str_contains($role, 'consultant') ? 'role-doctor'
                               : (str_contains($role, 'nurse') ? 'role-nurse'
                               : (str_contains($role, 'admin') ? 'role-admin' : 'role-other'));
                @endphp
                <tr class="staff-row">
    <td style="font-size:12px; color:#4a5568; font-weight:600;">
        {{ $member->staff_id ?? $member->id ?? '—' }}
    </td>
    <td>
        <div class="staff-name-cell">
            <div class="staff-avatar">{{ $initials }}</div>
            <div>
                <div class="staff-name">
                    {{ $member->first_name ?? '' }} {{ $member->last_name ?? $member->name ?? '—' }}
                </div>
                <div class="staff-email">{{ $member->email ?? '' }}</div>
            </div>
        </div>
    </td>
    <td>
        <span class="role-badge {{ $roleClass }}">
            {{ $member->position ?? $member->role ?? '—' }}
        </span>
    </td>
    <td style="color:#718096; font-size:12px;">
        {{ $member->ward_name ?? $member->ward ?? '—' }}
    </td>
    <td style="display:flex; gap:6px;">
        <a href="{{ route('staff.show', $member->staff_id ?? $member->id) }}" class="tbl-btn">View</a>
        <a href="{{ route('staff.edit', $member->staff_id ?? $member->id) }}" class="tbl-btn">Edit</a>
        <form method="POST" action="{{ route('staff.destroy', $member->staff_id ?? $member->id) }}" style="margin:0"
              onsubmit="return confirm('Remove this staff member?')">
            @csrf @method('DELETE')
            <button type="submit" class="tbl-btn tbl-btn-danger">✕</button>
        </form>
    </td>
</tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#5dade2; padding:2rem; font-size:13px;">
                        No staff records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="panel-pagination">
            {{ $staff->links() }}
        </div>
    </div>

    {{-- Right column --}}
    <div class="right-col">

        {{-- Today's Appointments --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Today's Appointments</span>
                <a href="{{ route('appointments.index') }}" class="panel-link">View all</a>
            </div>
            @forelse($todayAppointments as $appt)
            @php
                $pName = isset($appt->patient_first_name)
                    ? $appt->patient_first_name . ' ' . $appt->patient_last_name
                    : 'Patient #' . $appt->patient_id;
                $dName = isset($appt->doctor_last_name)
                    ? 'Dr. ' . $appt->doctor_last_name
                    : 'Consultant #' . $appt->consultant_id;
            @endphp
            <div class="appt-item">
                <div>
                    <div class="appt-name">{{ $pName }}</div>
                    <div class="appt-sub">{{ $dName }} &bull; Room {{ $appt->examination_room }}</div>
                </div>
                <div class="appt-time">
                    {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                </div>
            </div>
            @empty
            <div style="text-align:center; color:#5dade2; padding:1.5rem; font-size:13px;">
                No appointments today.
            </div>
            @endforelse
        </div>

        {{-- Bed Occupancy by Ward --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Bed Occupancy by Ward</span>
                <a href="{{ route('wards.index') }}" class="panel-link">View all</a>
            </div>
            @forelse($wardOccupancy as $ward)
            <div class="ward-item">
                <div class="ward-name">{{ $ward->ward_name }}</div>
                <div class="ward-bar-wrap">
                    <div class="ward-bar" style="width: {{ min($ward->percentage, 100) }}%;
                        background: {{ $ward->percentage >= 90 ? '#e74c3c' : ($ward->percentage >= 70 ? '#f39c12' : '#2e86c1') }};"></div>
                </div>
                <div class="ward-count">{{ $ward->occupied }}/{{ $ward->total_beds }}</div>
            </div>
            @empty
            <div style="text-align:center; color:#5dade2; padding:1.5rem; font-size:13px;">
                No ward data available.
            </div>
            @endforelse
        </div>

    </div>

</div>

<script>
function filterStaff(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#staffTable tbody .staff-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>

@endsection