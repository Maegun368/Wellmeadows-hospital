@extends('layouts.app')

@section('title', 'Ward & Bed Management')

@section('content')

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: #EAF1FB;
    font-family: 'Segoe UI', sans-serif;
    color: #1E293B;
}

.wbm-wrapper {
    padding: 0;
}

/* ── Topbar ── */
.wbm-topbar {
    background: #1a3451;
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.wbm-topbar h1 {
    font-size: 20px;
    font-weight: 700;
    color: white;
    letter-spacing: 0.3px;
}
.wbm-topbar p {
    margin-top: 3px;
    color: #DBEAFE;
    font-size: 12px;
}

/* ── Add Ward button (inside topbar) ── */
.wbm-add-btn {
    background: white;
    color: #1a3451;
    padding: 9px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
    border: 1px solid #CBD5E0;
    white-space: nowrap;
}
.wbm-add-btn:hover { background: #F0F4FF; }

/* ── Stats ── */
.wbm-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    padding: 18px 30px 0;
}
.wbm-stat {
    background: #3A7BD5;
    border-radius: 14px;
    padding: 22px 20px;
    color: white;
}
.wbm-stat h3 {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    opacity: 0.85;
    margin-bottom: 10px;
}
.wbm-stat p {
    font-size: 38px;
    font-weight: 700;
    line-height: 1;
}
.wbm-stat span {
    font-size: 12px;
    opacity: 0.75;
    display: block;
    margin-top: 6px;
}

/* ── Main grid ── */
.wbm-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 20px 30px 0;
}

/* ── Panel card ── */
.wbm-panel {
    background: #2D6DB5;
    border-radius: 16px;
    padding: 18px;
}
.wbm-panel-title {
    background: white;
    color: #1a3451;
    padding: 12px 16px;
    border-radius: 10px;
    text-align: center;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 0.4px;
    margin-bottom: 16px;
}

/* ── Ward info panel ── */
.wbm-selector {
    width: 100%;
    padding: 12px 14px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 14px;
    background: white;
    color: #1a3451;
}
.wbm-action-row {
    display: flex;
    gap: 10px;
    margin-bottom: 14px;
}
.wbm-action-row a {
    background: #1a3451;
    color: white;
    padding: 9px 22px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
}
.wbm-action-row a:hover { background: #243d5e; }
.wbm-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.wbm-info-box {
    background: white;
    border-radius: 8px;
    padding: 10px 14px;
    font-weight: 600;
    font-size: 12px;
    color: #1a3451;
}

/* ── Bed tracker ── */
.wbm-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.wbm-tab {
    background: white;
    color: #1a3451;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 700;
    font-size: 12px;
    cursor: pointer;
}
.wbm-tab.active {
    background: #1a3451;
    color: white;
}
.wbm-bed-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}
.wbm-bed {
    padding: 14px 6px;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    font-size: 12px;
}
.wbm-bed.occupied { background: #FCA5A5; color: #7F1D1D; }
.wbm-bed.vacant   { background: #BBF7D0; color: #14532D; }
.wbm-legend {
    margin-top: 14px;
    background: white;
    color: #1a3451;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    font-size: 12px;
    display: flex;
    justify-content: center;
    gap: 20px;
    align-items: center;
}
.wbm-legend span { display: flex; align-items: center; gap: 6px; }
.dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }
.dot.red   { background: #FCA5A5; border: 1.5px solid #EF4444; }
.dot.green { background: #BBF7D0; border: 1.5px solid #22C55E; }

/* ── Assign panel ── */
.wbm-assign-wrap {
    margin: 20px 30px 0;
    background: #2D6DB5;
    border-radius: 16px;
    padding: 18px;
}
.wbm-assign-form {
    background: #EEF4FF;
    border-radius: 12px;
    padding: 18px;
}
.wbm-form-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 12px;
}
.wbm-form-col {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.wbm-form-col label {
    font-size: 11px;
    font-weight: 700;
    color: #1a3451;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.wbm-form-grid input,
.wbm-form-grid select {
    padding: 11px 14px;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    background: white;
    color: #1a3451;
    outline: none;
    width: 100%;
}
.wbm-assign-btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 8px;
    background: #1a3451;
    color: white;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    letter-spacing: 0.4px;
}
.wbm-assign-btn:hover { background: #243d5e; }

/* ── Recent assignment ── */
.wbm-recent-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0 14px;
    gap: 12px;
}
.wbm-recent-title {
    background: white;
    color: #1a3451;
    padding: 11px 20px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    flex: 1;
    text-align: center;
}
.wbm-search-wrap {
    display: flex;
    gap: 8px;
    align-items: center;
}
.wbm-search-wrap input {
    padding: 9px 14px;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    outline: none;
    background: white;
    color: #1E293B;
    width: 200px;
}
.wbm-search-wrap button {
    padding: 9px 18px;
    background: #1a3451;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
}
.wbm-view-all {
    background: #1a3451;
    color: white;
    padding: 9px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 12px;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 6px;
}
.wbm-view-all:hover { background: #243d5e; color: white; }

.wbm-table-wrap {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}
.wbm-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.wbm-table th {
    background: #DBEAFE;
    color: #1E3A8A;
    padding: 12px 16px;
    text-align: left;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: 0.3px;
}
.wbm-table td {
    padding: 13px 16px;
    border-bottom: 1px solid #F0F4FF;
    color: #1E293B;
}
.wbm-table tbody tr:last-child td { border-bottom: none; }
.wbm-table tbody tr:hover { background: #F8FAFF; }

.badge-occupied {
    background: #DCFCE7;
    color: #166534;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
}
.badge-discharged {
    background: #FEE2E2;
    color: #991B1B;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
}
.badge-waiting {
    background: #FEF3C7;
    color: #92400E;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
}

/* Alerts */
.wbm-alert {
    margin: 0 30px 16px;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
}
.wbm-alert-success { background: #D1FAE5; color: #065F46; }
.wbm-alert-error   { background: #FEE2E2; color: #991B1B; }

.wbm-bottom-space { height: 30px; }
</style>

<div class="wbm-wrapper">

    {{-- TOPBAR --}}
    <div class="wbm-topbar">
        <div>
            <h1>Ward &amp; Bed Management</h1>
            <p>{{ now()->format('F d, Y | h:i A') }}</p>
        </div>
        @can('create wards')
            <a href="{{ route('wards.create') }}" class="wbm-add-btn">+ Add Ward</a>
        @endcan
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="wbm-alert wbm-alert-success" style="margin-top:16px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="wbm-alert wbm-alert-error" style="margin-top:16px;">{{ session('error') }}</div>
    @endif
    @if($errors->has('ward'))
        <div class="wbm-alert wbm-alert-error" style="margin-top:16px;">{{ $errors->first('ward') }}</div>
    @endif

    {{-- STATS --}}
    <div class="wbm-stats">
        <div class="wbm-stat">
            <h3>Total Wards</h3>
            <p>{{ $wards->count() }}</p>
            <span>Active wards</span>
        </div>
        <div class="wbm-stat">
            <h3>Total Beds</h3>
            <p>{{ $wards->sum('total_beds') }}</p>
            <span>Across all wards</span>
        </div>
        <div class="wbm-stat">
            <h3>Occupied Beds</h3>
            <p>{{ $wards->sum('occupied_beds') }}</p>
            <span>Currently in use</span>
        </div>
        <div class="wbm-stat">
            <h3>Vacant Beds</h3>
            <p>{{ $wards->sum('total_beds') - $wards->sum('occupied_beds') }}</p>
            <span>Available now</span>
        </div>
    </div>

    {{-- MAIN PANELS --}}
    <div class="wbm-main">

        {{-- LEFT: Ward Info --}}
        <div class="wbm-panel">
            <div class="wbm-panel-title">MAINTAIN WARD INFORMATION</div>

            <select id="wardSelector" onchange="changeWard()" class="wbm-selector">
                @foreach($wards as $ward)
                    <option
                        value="{{ $ward->ward_id }}"
                        data-id="{{ $ward->ward_id }}"
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

            <div class="wbm-action-row">
                <a href="#" id="viewBtn">View</a>
                @can('edit wards')
                    <a href="#" id="editBtn">Edit</a>
                @endcan
            </div>

            <div class="wbm-info-grid">
                <div class="wbm-info-box" id="infoWardId">Ward ID: —</div>
                <div class="wbm-info-box" id="infoWardName">—</div>
                <div class="wbm-info-box" id="infoLocation">—</div>
                <div class="wbm-info-box" id="infoCapacity">Capacity: —</div>
                <div class="wbm-info-box" id="infoAvailable">Available: —</div>
            </div>
        </div>

        {{-- RIGHT: Bed Tracker --}}
        <div class="wbm-panel">
            <div class="wbm-panel-title">TRACK OCCUPIED &amp; VACANT BEDS</div>

            <div class="wbm-tabs">
                @foreach($wards as $index => $ward)
                    <button
                        class="wbm-tab {{ $index == 0 ? 'active' : '' }}"
                        onclick="showBeds({{ $ward->ward_id }}, this)">
                        {{ $ward->ward_name }}
                    </button>
                @endforeach
            </div>

            @foreach($wards as $index => $ward)
                @php
                    $occupiedBeds = \App\Models\BedAllocation::where('ward_id', $ward->ward_id)
                        ->whereNull('actual_leave_date')
                        ->whereNotNull('date_placed')
                        ->pluck('bed_number')
                        ->toArray();
                @endphp
                <div class="wbm-bed-grid ward-beds"
                     id="beds-{{ $ward->ward_id }}"
                     style="{{ $index != 0 ? 'display:none;' : '' }}">
                    @for($i = 1; $i <= $ward->total_beds; $i++)
                        <div class="wbm-bed {{ in_array($i, $occupiedBeds) ? 'occupied' : 'vacant' }}">
                            Bed {{ $i }}
                        </div>
                    @endfor
                </div>
            @endforeach

            <div class="wbm-legend">
                <span><span class="dot red"></span> Occupied</span>
                <span><span class="dot green"></span> Vacant</span>
            </div>
        </div>

    </div>

    {{-- ASSIGN PANEL --}}
    <div class="wbm-assign-wrap">
        <div class="wbm-panel-title">ASSIGN BED TO ADMITTED PATIENT</div>

        <div class="wbm-assign-form">
            <form action="{{ route('bed-allocations.store') }}" method="POST">
                @csrf

                {{-- Row 1: Patient ID | Patient | Ward | Bed Number --}}
                <div class="wbm-form-grid">
                    <div class="wbm-form-col">
                        <label>Patient ID</label>
                        <input type="number"
                               id="assignPatientId"
                               name="patient_id"
                               placeholder="Patient ID"
                               value="{{ old('patient_id') }}"
                               min="1"
                               required>
                    </div>

                    <div class="wbm-form-col">
                        <label>Patient</label>
                        <select id="assignPatientSelect" onchange="syncPatientFromSelect()">
                            <option value="">— Select Patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->last_name }}, {{ $patient->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="wbm-form-col">
                        <label>Select Ward</label>
                        <select name="ward_id" required>
                            <option value="">Select Ward</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->ward_id }}" {{ old('ward_id') == $ward->ward_id ? 'selected' : '' }}>
                                    {{ $ward->ward_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="wbm-form-col">
                        <label>Bed Number</label>
                        <input type="number"
                               name="bed_number"
                               placeholder="Bed Number"
                               value="{{ old('bed_number') }}"
                               min="1"
                               required>
                    </div>
                </div>

                {{-- Row 2: Date Placed Waiting | Expected Duration | Expected Leave | Date Placed --}}
                <div class="wbm-form-grid">
                    <div class="wbm-form-col">
                        <label>Date Placed Waiting</label>
                        <input type="date" name="date_placed_waiting" value="{{ old('date_placed_waiting') }}">
                    </div>

                    <div class="wbm-form-col">
                        <label>Expected Duration (Days)</label>
                        <input type="number"
                               name="expected_duration_days"
                               placeholder="e.g. 5"
                               value="{{ old('expected_duration_days') }}"
                               min="1">
                    </div>

                    <div class="wbm-form-col">
                        <label>Expected Leave Date</label>
                        <input type="date" name="date_expected_leave" value="{{ old('date_expected_leave') }}">
                    </div>

                    <div class="wbm-form-col">
                        <label>Date Placed</label>
                        <input type="date" name="date_placed" value="{{ old('date_placed') }}">
                    </div>
                </div>

                <button type="submit" class="wbm-assign-btn">Assign Bed</button>
            </form>

            {{-- Recent Assignment --}}
            <div class="wbm-recent-header">
                <div class="wbm-recent-title">RECENT ASSIGNMENT</div>
                <div class="wbm-search-wrap">
                    <input type="text" id="recentSearch" placeholder="Search by patient name..." oninput="filterRecent()">
                    <button type="button" onclick="filterRecent()">Search</button>
                </div>
                <a href="{{ route('bed-allocations.index') }}" class="wbm-view-all">📋 View All Allocations</a>
            </div>

            <div class="wbm-table-wrap">
                @php
                    $recentAllocations = \App\Models\BedAllocation::with(['ward', 'patient'])
                        ->latest('allocation_id')
                        ->take(5)
                        ->get();
                @endphp
                <table class="wbm-table" id="recentTable">
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
                            <tr class="recent-row">
                                <td>{{ $allocation->patient_id }}</td>
                                <td class="patient-name-cell">
                                    {{ optional($allocation->patient)->first_name }}
                                    {{ optional($allocation->patient)->last_name }}
                                </td>
                                <td>{{ optional($allocation->ward)->ward_name }}</td>
                                <td>Bed {{ $allocation->bed_number }}</td>
                                <td>
                                    @if($allocation->actual_leave_date)
                                        <span class="badge-discharged">Discharged</span>
                                    @elseif($allocation->date_placed)
                                        <span class="badge-occupied">Occupied</span>
                                    @else
                                        <span class="badge-waiting">On Waiting List</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:25px; color:#94A3B8;">
                                    No recent assignments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="wbm-bottom-space"></div>

</div>

<script>
// ── Ward info panel ──
function changeWard() {
    const sel = document.getElementById('wardSelector');
    const opt = sel.options[sel.selectedIndex];
    document.getElementById('infoWardId').textContent    = 'Ward ID: ' + opt.dataset.id;
    document.getElementById('infoWardName').textContent  = opt.dataset.name;
    document.getElementById('infoLocation').textContent  = opt.dataset.location;
    document.getElementById('infoCapacity').textContent  = 'Capacity: ' + opt.dataset.capacity;
    document.getElementById('infoAvailable').textContent = 'Available: ' + opt.dataset.available;
    document.getElementById('viewBtn').href = opt.dataset.view;
    document.getElementById('editBtn').href = opt.dataset.edit;
}
changeWard();

// ── Bed tracker tabs ──
function showBeds(wardId, btn) {
    document.querySelectorAll('.ward-beds').forEach(el => el.style.display = 'none');
    document.getElementById('beds-' + wardId).style.display = 'grid';
    document.querySelectorAll('.wbm-tab').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
}

// ── Patient ID ↔ Patient select sync ──
document.getElementById('assignPatientId').addEventListener('input', function () {
    const id = this.value;
    const sel = document.getElementById('assignPatientSelect');
    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value == id) {
            sel.selectedIndex = i;
            return;
        }
    }
    sel.selectedIndex = 0;
});

function syncPatientFromSelect() {
    const sel = document.getElementById('assignPatientSelect');
    const idInput = document.getElementById('assignPatientId');
    idInput.value = sel.value || '';
}

// ── Recent table search ──
function filterRecent() {
    const q = document.getElementById('recentSearch').value.toLowerCase();
    document.querySelectorAll('.recent-row').forEach(row => {
        const name = row.querySelector('.patient-name-cell').textContent.toLowerCase();
        row.style.display = name.includes(q) ? '' : 'none';
    });
}
</script>

@endsection