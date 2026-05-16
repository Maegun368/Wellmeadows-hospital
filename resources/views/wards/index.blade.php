@extends('layouts.app')
@section('title', 'Ward & Bed Management')
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
.ward-topbar {
    background: var(--blue-dark);
    padding: 14px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.ward-topbar h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.ward-topbar-sub { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 2px; }
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

/* ── Stat cards ── */
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
.stat-card.dark   { background: var(--blue-dark); }
.stat-card.accent { background: var(--blue-accent); }
.stat-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: rgba(255,255,255,0.7);
    margin-bottom: 8px;
}
.stat-value { font-size: 32px; font-weight: 700; color: var(--white); line-height: 1; }
.stat-sub   { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 6px; }

/* ── Body ── */
.ward-body {
    padding: 20px 24px;
    background: var(--blue-bg);
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ── Main grid ── */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* ── Panel ── */
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
.panel-body { padding: 16px; }

/* ── Ward selector ── */
.selector {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--blue-pale);
    border-radius: 8px;
    font-size: 13px;
    color: var(--blue-dark);
    font-weight: 600;
    margin-bottom: 12px;
    background: #f0f8ff;
}
.action-buttons { display: flex; gap: 8px; margin-bottom: 14px; }
.action-buttons a {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid var(--blue-mid);
    color: var(--blue-dark);
    background: var(--white);
    transition: background .15s;
}
.action-buttons a:hover { background: var(--blue-pale); }

.ward-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.ward-form select {
    padding: 10px 12px;
    border: 1px solid var(--blue-pale);
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: var(--blue-dark);
    background: #f0f8ff;
}

/* ── Bed tabs ── */
.tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
.tab-btn {
    background: var(--white);
    color: var(--blue-dark);
    border: 1px solid var(--blue-mid);
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: all .15s;
}
.tab-btn.active, .tab-btn:hover {
    background: var(--blue-dark);
    color: var(--white);
    border-color: var(--blue-dark);
}
.bed-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
.bed {
    padding: 12px 6px;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    font-size: 11px;
}
.occupied { background: #fca5a5; color: #7f1d1d; }
.vacant   { background: #d9f99d; color: #14532d; }
.legend {
    margin-top: 14px;
    background: #f0f8ff;
    border: 1px solid var(--blue-pale);
    color: var(--blue-dark);
    padding: 10px;
    border-radius: 8px;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
}

/* ── Assign panel ── */
.assign-panel {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
}
.assign-content { padding: 16px; background: #f0f8ff; }
.assign-form {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 12px;
}
.assign-form input,
.assign-form select {
    padding: 10px 12px;
    border: 1px solid var(--blue-pale);
    border-radius: 8px;
    font-size: 13px;
    color: var(--blue-dark);
    background: var(--white);
}
.assign-btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: var(--blue-dark);
    color: var(--white);
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: opacity .15s;
}
.assign-btn:hover { opacity: 0.9; }

/* ── Overview table ── */
.overview-box {
    margin-top: 16px;
    background: var(--white);
    border-radius: 10px;
    border: 1px solid var(--blue-pale);
    overflow: hidden;
}
.overview-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.overview-table th {
    background: #f0f8ff;
    padding: 10px 12px;
    text-align: left;
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid var(--blue-pale);
}
.overview-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #f0f8ff;
    color: #2d3748;
}
.overview-table tr:last-child td { border-bottom: none; }
.overview-table tr:hover td { background: #f0f8ff; }
.badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-red   { background: #fadbd8; color: #c0392b; }
.badge-green { background: #d5f5e3; color: #1e8449; }
</style>

{{-- Top bar --}}
<div class="ward-topbar">
    <div>
        <h2>Ward & Bed Management</h2>
        <div class="ward-topbar-sub">{{ now()->format('F d, Y | h:i A') }}</div>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <input type="text" placeholder="Search..." class="topbar-search">
        <a href="{{ route('wards.create') }}" class="btn-add">+ Add Ward</a>
    </div>
</div>

{{-- Stat cards --}}
<div class="stat-row">
    <div class="stat-card">
        <div class="stat-label">Total Wards</div>
        <div class="stat-value">{{ $wards->count() }}</div>
        <div class="stat-sub">Active wards</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-label">Total Beds</div>
        <div class="stat-value">{{ $wards->sum('total_beds') }}</div>
        <div class="stat-sub">Across all wards</div>
    </div>
    <div class="stat-card accent">
        <div class="stat-label">Occupied Beds</div>
        <div class="stat-value">{{ \App\Models\BedAllocation::whereNull('actual_leave_date')->count() }}</div>
        <div class="stat-sub">Currently admitted</div>
    </div>
    <div class="stat-card dark">
        <div class="stat-label">Vacant Beds</div>
        <div class="stat-value">{{ $wards->sum('total_beds') - \App\Models\BedAllocation::whereNull('actual_leave_date')->count() }}</div>
        <div class="stat-sub">Available now</div>
    </div>
</div>

{{-- Body --}}
<div class="ward-body">

    {{-- Main grid --}}
    <div class="main-grid">

        {{-- Left: Maintain Ward --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Maintain Ward Information</span>
            </div>
            <div class="panel-body">
                <select id="wardSelector" onchange="changeWard()" class="selector">
                    @foreach($wards as $ward)
                        <option
                            value="{{ $ward->ward_id }}"
                            data-name="{{ $ward->ward_name }}"
                            data-location="{{ $ward->location }}"
                            data-capacity="{{ $ward->total_beds }}"
                            data-available="{{ $ward->available_beds }}"
                            data-view="{{ route('wards.show', $ward->ward_id) }}"
                            data-edit="{{ route('wards.edit', $ward->ward_id) }}">
                            {{ $ward->ward_name }}
                        </option>
                    @endforeach
                </select>
                <div class="action-buttons">
                    <a href="#" id="viewBtn">View</a>
                    <a href="#" id="editBtn">Edit</a>
                </div>
                <div class="ward-form">
                    <select><option id="wardName"></option></select>
                    <select><option id="wardLocation"></option></select>
                    <select><option id="wardCapacity"></option></select>
                    <select><option id="wardAvailable"></option></select>
                </div>
            </div>
        </div>

        {{-- Right: Bed tracker --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Track Occupied & Vacant Beds</span>
            </div>
            <div class="panel-body">
                <div class="tabs">
                    @foreach($wards as $index => $ward)
                        <button class="tab-btn {{ $index == 0 ? 'active' : '' }}"
                                onclick="showBeds({{ $ward->ward_id }}, this)">
                            {{ $ward->ward_name }}
                        </button>
                    @endforeach
                </div>

                @foreach($wards as $index => $ward)
                    @php
                        $occupiedBeds = \App\Models\BedAllocation::where('ward_id', $ward->ward_id)
                            ->whereNull('actual_leave_date')
                            ->pluck('bed_number')->toArray();
                    @endphp
                    <div class="bed-grid ward-beds" id="beds-{{ $ward->ward_id }}"
                         style="{{ $index != 0 ? 'display:none;' : '' }}">
                        @for($i = 1; $i <= $ward->total_beds; $i++)
                            <div class="bed {{ in_array($i, $occupiedBeds) ? 'occupied' : 'vacant' }}">
                                Bed {{ $i }}
                            </div>
                        @endfor
                    </div>
                @endforeach

                <div class="legend">🟥 Occupied &nbsp;&nbsp;&nbsp; 🟩 Vacant</div>
            </div>
        </div>

    </div>

    {{-- Assign panel --}}
    <div class="assign-panel">
        <div class="panel-header">
            <span class="panel-title">Assign Bed to Admitted Patient</span>
        </div>
        <div class="assign-content">
            <form action="{{ route('bed-allocations.store') }}" method="POST">
                @csrf
                <div class="assign-form">
                    <select name="patient_id" required>
                        <option value="">Select patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>
                                {{ $patient->last_name }}, {{ $patient->first_name }} (ID {{ $patient->id }})
                            </option>
                        @endforeach
                    </select>
                    <select name="ward_id" required>
                        <option value="">Select Ward</option>
                        @foreach($wards as $ward)
                            <option value="{{ $ward->ward_id }}">{{ $ward->ward_name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="bed_number" placeholder="Bed Number" required>
                    <input type="date" name="date_expected_leave">
                </div>
                <button type="submit" class="assign-btn">Assign Bed</button>
            </form>

            {{-- Recent assignments --}}
            <div class="overview-box">
                @php
                    $recentAllocations = \App\Models\BedAllocation::with(['ward', 'patient'])
                        ->latest()->take(5)->get();
                @endphp
                <table class="overview-table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Ward</th>
                            <th>Bed</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAllocations as $allocation)
                            <tr>
                                <td>{{ $allocation->patient_id }}</td>
                                <td>{{ optional($allocation->patient)->first_name }} {{ optional($allocation->patient)->last_name }}</td>
                                <td>{{ optional($allocation->ward)->ward_name }}</td>
                                <td>Bed {{ $allocation->bed_number }}</td>
                                <td>
                                    @if($allocation->actual_leave_date)
                                        <span class="badge badge-red">Discharged</span>
                                    @else
                                        <span class="badge badge-green">Occupied</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:20px; color:#718096;">
                                    No recent assignments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
function changeWard() {
    let selector = document.getElementById('wardSelector');
    let selected = selector.options[selector.selectedIndex];
    document.getElementById('wardName').textContent      = selected.dataset.name;
    document.getElementById('wardLocation').textContent  = selected.dataset.location;
    document.getElementById('wardCapacity').textContent  = 'Capacity: ' + selected.dataset.capacity;
    document.getElementById('wardAvailable').textContent = 'Available: ' + selected.dataset.available;
    document.getElementById('viewBtn').href              = selected.dataset.view;
    document.getElementById('editBtn').href              = selected.dataset.edit;
}
changeWard();

function showBeds(wardId, btn) {
    document.querySelectorAll('.ward-beds').forEach(el => el.style.display = 'none');
    document.getElementById('beds-' + wardId).style.display = 'grid';
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
}
</script>

@endsection