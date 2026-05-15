@extends('layouts.app')

@section('title', 'Ward & Bed Management')

@section('content')

<style>
:root{
    --blue-dark:#1a5276;
    --blue-mid:#2e86c1;
    --blue-light:#5dade2;
    --blue-accent:#2980b9;
    --blue-pale:#d6eaf8;
    --blue-bg:#e8f4fd;
    --white:#ffffff;
}

/* ───────────────── GLOBAL ───────────────── */
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    background:var(--blue-bg);
    font-family:'Open Sans',sans-serif;
    color:#2d3748;
}

.wbm-wrapper{
    background:var(--blue-bg);
    min-height:100vh;
    padding-bottom:30px;
}

/* ───────────────── TOPBAR ───────────────── */
.wbm-topbar{
    background:var(--blue-dark);
    padding:14px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
}

.wbm-topbar h1{
    font-size:18px;
    font-weight:700;
    color:white;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.wbm-topbar p{
    color:rgba(255,255,255,.55);
    font-size:11px;
    margin-top:2px;
}

/* ───────────────── STATS ───────────────── */
.wbm-stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
    padding:20px 24px 0;
}

.wbm-stat{
    background:var(--blue-mid);
    border-radius:10px;
    padding:18px 20px;
    color:white;
}

.wbm-stat:nth-child(2),
.wbm-stat:nth-child(4){
    background:var(--blue-dark);
}

.wbm-stat:nth-child(3){
    background:var(--blue-accent);
}

.wbm-stat h3{
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.07em;
    color:rgba(255,255,255,.7);
    margin-bottom:8px;
}

.wbm-stat p{
    font-size:32px;
    font-weight:700;
    line-height:1;
}

.wbm-stat span{
    font-size:11px;
    color:rgba(255,255,255,.55);
    margin-top:6px;
    display:block;
}

/* ───────────────── MAIN GRID ───────────────── */
.wbm-main{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    padding:20px 24px;
}

/* ───────────────── PANELS ───────────────── */
.wbm-panel,
.wbm-assign-wrap{
    background:white;
    border:2px solid var(--blue-mid);
    border-radius:12px;
    overflow:hidden;
}

.wbm-panel-title{
    background:var(--blue-mid);
    color:white;
    padding:10px 16px;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    margin:0;
    border:none;
    border-radius:0;
    text-align:left;
}

/* ───────────────── PANEL CONTENT ───────────────── */
.wbm-panel{
    padding-bottom:16px;
}

.wbm-selector,
.wbm-info-grid select,
.wbm-form-fields input,
.wbm-form-fields select{
    width:100%;
    padding:10px 12px;
    border:1px solid var(--blue-pale);
    border-radius:8px;
    background:white;
    font-size:13px;
    color:#2d3748;
}

.wbm-selector{
    margin:16px;
    width:calc(100% - 32px);
}

.wbm-selector:focus,
.wbm-form-fields input:focus,
.wbm-form-fields select:focus{
    outline:none;
    border-color:var(--blue-mid);
}

/* ───────────────── ACTION BUTTONS ───────────────── */
.wbm-action-row{
    display:flex;
    gap:10px;
    margin:0 16px 16px;
}

.wbm-action-row a{
    background:var(--blue-dark);
    color:white;
    border:none;
    padding:9px 18px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    transition:.15s;
}

.wbm-action-row a:hover{
    opacity:.9;
}

/* ───────────────── INFO GRID ───────────────── */
.wbm-info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
    padding:0 16px;
}

/* ───────────────── BED TRACKER ───────────────── */
.wbm-tabs{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    padding:16px;
}

.wbm-tab{
    background:white;
    border:1px solid var(--blue-mid);
    color:var(--blue-dark);
    border-radius:8px;
    padding:8px 16px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
}

.wbm-tab.active{
    background:var(--blue-dark);
    color:white;
}

.wbm-bed-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
    padding:0 16px 16px;
}

.wbm-bed{
    padding:14px;
    border-radius:8px;
    text-align:center;
    font-size:12px;
    font-weight:700;
}

.wbm-bed.occupied{
    background:#fadbd8;
    color:#c0392b;
}

.wbm-bed.vacant{
    background:#d5f5e3;
    color:#1e8449;
}

/* ───────────────── LEGEND ───────────────── */
.wbm-legend{
    display:flex;
    justify-content:flex-end;
    gap:20px;
    padding:0 16px 16px;
    font-size:12px;
    color:#4a5568;
}

.wbm-legend span{
    display:flex;
    align-items:center;
    gap:6px;
}

.dot{
    width:10px;
    height:10px;
    border-radius:50%;
}

.dot.red{
    background:#e74c3c;
}

.dot.green{
    background:#2ecc71;
}

/* ───────────────── ASSIGN PANEL ───────────────── */
.wbm-assign-wrap{
    margin:0 24px;
}

.wbm-assign-form{
    padding:16px;
}

.wbm-form-fields{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:16px;
}

.wbm-form-group{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.wbm-form-group label{
    font-size:11px;
    font-weight:700;
    color:var(--blue-dark);
    text-transform:uppercase;
}

/* ───────────────── ASSIGN BUTTON ───────────────── */
.wbm-assign-btn{
    width:100%;
    background:var(--blue-dark);
    color:white;
    border:none;
    padding:12px;
    border-radius:8px;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
}

.wbm-assign-btn:hover{
    opacity:.9;
}

/* ───────────────── RECENT HEADER ───────────────── */
.wbm-recent-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:20px 0 14px;
    gap:12px;
    flex-wrap:wrap;
}

.wbm-recent-title{
    font-size:12px;
    font-weight:700;
    color:var(--blue-dark);
    text-transform:uppercase;
}

.wbm-view-all{
    background:var(--blue-dark);
    color:white;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:12px;
    font-weight:600;
}

/* ───────────────── TABLE ───────────────── */
.wbm-table-wrap{
    border:1px solid var(--blue-pale);
    border-radius:10px;
    overflow:hidden;
}

.wbm-table{
    width:100%;
    border-collapse:collapse;
    font-size:13px;
}

.wbm-table th{
    background:#f0f8ff;
    color:var(--blue-dark);
    text-align:left;
    padding:10px 14px;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
}

.wbm-table td{
    padding:12px 14px;
    border-bottom:1px solid #eef4ff;
}

.wbm-table tr:last-child td{
    border-bottom:none;
}

.wbm-table tbody tr:hover{
    background:#f8fbff;
}

/* ───────────────── BADGES ───────────────── */
.badge-occupied{
    background:#d5f5e3;
    color:#1e8449;
    padding:4px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

.badge-discharged{
    background:#fadbd8;
    color:#c0392b;
    padding:4px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

.badge-waiting{
    background:#fef9c3;
    color:#854d0e;
    padding:4px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

/* ───────────────── RESPONSIVE ───────────────── */
@media(max-width:1100px){
    .wbm-stats,
    .wbm-main,
    .wbm-form-fields{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:768px){
    .wbm-stats,
    .wbm-main,
    .wbm-form-fields,
    .wbm-info-grid{
        grid-template-columns:1fr;
    }

    .wbm-topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .wbm-bed-grid{
        grid-template-columns:1fr 1fr;
    }

    .wbm-recent-header{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>

<div class="wbm-wrapper">

    {{-- TOPBAR --}}
    <div class="wbm-topbar">
        <div>
            <h1>Ward & Bed Management</h1>
            <p>{{ now()->format('F d, Y | h:i A') }}</p>
        </div>
    </div>

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
            <p>{{ \App\Models\BedAllocation::whereNull('actual_leave_date')->whereNotNull('date_placed')->count() }}</p>
            <span>Currently admitted</span>
        </div>
        <div class="wbm-stat">
            <h3>Vacant Beds</h3>
            <p>{{ $wards->sum('total_beds') - \App\Models\BedAllocation::whereNull('actual_leave_date')->whereNotNull('date_placed')->count() }}</p>
            <span>Available now</span>
        </div>
    </div>

    {{-- MAIN PANELS --}}
    <div class="wbm-main">

        {{-- LEFT: Ward Info --}}
        <div class="wbm-panel">
            <div class="wbm-panel-title">Maintain Ward Information</div>

            <select id="wardSelector" onchange="changeWard()" class="wbm-selector">
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

            <div class="wbm-action-row">
                <a href="#" id="viewBtn">View</a>
                <a href="#" id="editBtn">Edit</a>
            </div>

            <div class="wbm-info-grid">
                <select><option id="wardId"></option></select>
                <select><option id="wardName"></option></select>
                <select><option id="wardLocation"></option></select>
                <select><option id="wardCapacity"></option></select>
                <select><option id="wardAvailable"></option></select>
            </div>
        </div>

        {{-- RIGHT: Bed Tracker --}}
        <div class="wbm-panel">
            <div class="wbm-panel-title">Track Occupied & Vacant Beds</div>

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
        <div class="wbm-panel-title">Assign Bed to Admitted Patient</div>

        <div class="wbm-assign-form">
            <form action="{{ route('bed-allocations.store') }}" method="POST">
                @csrf

                <div class="wbm-form-fields">

                    <div class="wbm-form-group">
                        <label>Patient ID</label>
                        <input type="text" name="patient_id_display"
                               placeholder="Patient ID"
                               value="{{ old('patient_id') }}" readonly style="background:#f1f5f9;">
                    </div>

                    <div class="wbm-form-group">
                        <label>Patient</label>
                        <select name="patient_id" required id="patientSelect" onchange="syncPatientId()">
                            <option value="">— Select Patient —</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->last_name }}, {{ $patient->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="wbm-form-group">
                        <label>Select Ward</label>
                        <select name="ward_id" required>
                            <option value="">— Select Ward —</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->ward_id }}" {{ old('ward_id') == $ward->ward_id ? 'selected' : '' }}>
                                    {{ $ward->ward_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="wbm-form-group">
                        <label>Bed Number</label>
                        <input type="number" name="bed_number" min="1"
                               placeholder="Bed Number"
                               value="{{ old('bed_number') }}" required>
                    </div>

                    <div class="wbm-form-group">
                        <label>Date Placed Waiting</label>
                        <input type="date" name="date_placed_waiting"
                               value="{{ old('date_placed_waiting') }}">
                    </div>

                    <div class="wbm-form-group">
                        <label>Expected Duration (days)</label>
                        <input type="number" name="expected_duration_days" min="1"
                               placeholder="e.g. 5"
                               value="{{ old('expected_duration_days') }}">
                    </div>

                    <div class="wbm-form-group">
                        <label>Expected Leave Date</label>
                        <input type="date" name="date_expected_leave"
                               value="{{ old('date_expected_leave') }}">
                    </div>

                    <div class="wbm-form-group">
                        <label>Date Placed</label>
                        <input type="date" name="date_placed"
                               value="{{ old('date_placed') }}">
                    </div>

                </div>

                @if(session('error'))
                    <div style="background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:12px; font-size:13px;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:12px; font-size:13px;">
                        <ul style="margin:0; padding-left:1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="submit" class="wbm-assign-btn">Assign Bed</button>
            </form>

            {{-- Recent Assignment with working Search --}}
            <div class="wbm-recent-header">
                <div class="wbm-recent-title">Recent Assignment</div>
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <form method="GET" action="{{ url()->current() }}" style="display:flex; gap:8px; align-items:center;">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by patient name..."
                               style="width:210px; padding:8px 14px; border:1px solid var(--blue-pale); border-radius:8px; font-size:13px; outline:none; color:#1a5276; background:white;">
                        <button type="submit"
                                style="padding:8px 16px; background:var(--blue-dark); color:white; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer;">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ url()->current() }}"
                               style="padding:8px 12px; background:#e2e8f0; color:#4a5568; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none;">
                                ✕ Clear
                            </a>
                        @endif
                    </form>
                    <a href="{{ route('bed-allocations.index') }}" class="wbm-view-all">📋 View All Allocations</a>
                </div>
            </div>

            <div class="wbm-table-wrap">

                {{-- ✅ THE FIX: query now filters by search term --}}
                @php
                    $searchTerm = request('search');
                    $recentAllocations = \App\Models\BedAllocation::with(['ward', 'patient'])
                        ->latest('allocation_id')
                        ->when($searchTerm, function ($query) use ($searchTerm) {
                            $query->whereHas('patient', function ($q) use ($searchTerm) {
                                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                                  ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                            });
                        })
                        ->take(10)
                        ->get();
                @endphp

                <table class="wbm-table">
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
                                <td>
                                    {{ optional($allocation->patient)->first_name }}
                                    {{ optional($allocation->patient)->last_name }}
                                </td>
                                <td>{{ optional($allocation->ward)->ward_name }}</td>
                                <td>Bed {{ $allocation->bed_number }}</td>
                                <td>
                                    @if($allocation->actual_leave_date)
                                        <span class="badge-discharged">Discharged</span>
                                    @elseif($allocation->date_placed_waiting && !$allocation->date_placed)
                                        <span class="badge-waiting">On Waiting List</span>
                                    @else
                                        <span class="badge-occupied">Occupied</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:25px; color:#94A3B8;">
                                    @if(request('search'))
                                        No results found for "{{ request('search') }}".
                                    @else
                                        No recent assignments found.
                                    @endif
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
    const sel = document.getElementById('wardSelector');
    const opt = sel.options[sel.selectedIndex];
    document.getElementById('wardId').textContent        = 'Ward ID: ' + sel.value;
    document.getElementById('wardName').textContent      = opt.dataset.name;
    document.getElementById('wardLocation').textContent  = opt.dataset.location;
    document.getElementById('wardCapacity').textContent  = 'Capacity: ' + opt.dataset.capacity;
    document.getElementById('wardAvailable').textContent = 'Available: ' + opt.dataset.available;
    document.getElementById('viewBtn').href = opt.dataset.view;
    document.getElementById('editBtn').href = opt.dataset.edit;
}
changeWard();

function showBeds(wardId, btn) {
    document.querySelectorAll('.ward-beds').forEach(el => el.style.display = 'none');
    document.getElementById('beds-' + wardId).style.display = 'grid';
    document.querySelectorAll('.wbm-tab').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
}

function syncPatientId() {
    const sel = document.getElementById('patientSelect');
    const display = document.querySelector('input[name="patient_id_display"]');
    if (display) display.value = sel.value;
}
</script>

@endsection