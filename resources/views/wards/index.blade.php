@extends('layouts.app')

@section('title', 'Ward & Bed Management')

@section('content')

<style>

body{
    background:#F4F7FB;
    font-family:'Times New Roman',Times,serif;
    color:#1E293B;
    margin:0;
    padding:0;
}

.dashboard-wrapper{
    padding:0;
}

.content-area{
    width:100%;
    padding:0;
    margin:0;
}

.dashboard-wrapper{
    width:100%;
    margin:0;
    padding:0;
}

.main-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    width:100%;
}

body{
    overflow-x:hidden;
}

.topbar{
    background:#1a3451;
    padding:18px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    width:100%;
    margin:0;
    border-radius:0;
    box-shadow:none;
}

.topbar-left{
    display:flex;
    flex-direction:column;
}

.topbar h1{
    font-size:22px;
    font-weight:700;
    color:white;
    margin:0;
}

.topbar p{
    margin-top:4px;
    color:#DBEAFE;
    font-size:12px;
    font-weight:500;
}

.search-box{
    width:250px;
    padding:10px 14px;
    border:none;
    border-radius:10px;
    font-size:14px;
    outline:none;
    background:white;
}

.add-btn{
    display:inline-block;
    background:white;
    color:#111827;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
    font-weight:700;
    margin-bottom:20px;
    border:1px solid #D1D5DB;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:linear-gradient(135deg,#6BA6E9,#79B2F2);
    padding:25px;
    border-radius:18px;
    color:white;
}

.stat-card h3{
    font-size:15px;
    margin-bottom:10px;
}

.stat-card p{
    font-size:42px;
    font-weight:700;
}

.main-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    margin-bottom:25px;
}

.panel{
    background:linear-gradient(135deg,#1F6DB7,#2D7DD2);
    border-radius:20px;
    padding:20px;
    color:white;
}

.panel-title{
    background:white;
    color:#111827;
    padding:14px;
    border-radius:12px;
    text-align:center;
    font-weight:700;
    margin-bottom:20px;
}

.action-buttons{
    display:flex;
    gap:10px;
    margin-bottom:18px;
}

.action-buttons a{
    background:white;
    color:#111827;
    padding:10px 16px;
    border-radius:10px;
    text-decoration:none;
    font-weight:700;
}

.selector{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    margin-bottom:18px;
    font-weight:700;
}

.ward-form{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

.ward-form select{
    padding:14px;
    border:none;
    border-radius:10px;
    font-weight:600;
    background:white;
}

.save-btn{
    width:100%;
    margin-top:18px;
    padding:14px;
    border:none;
    border-radius:10px;
    font-weight:700;
    background:#DBEAFE;
    cursor:pointer;
}

.tabs{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:18px;
}

.tab-btn{
    background:white;
    color:#111827;
    border:none;
    border-radius:10px;
    padding:10px 16px;
    font-weight:700;
    cursor:pointer;
}

.tab-btn.active{
    background:#DBEAFE;
    color:#1E40AF;
}

.bed-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:10px;
}

.bed{
    padding:16px;
    border-radius:10px;
    text-align:center;
    font-weight:700;
    font-size:13px;
}

.occupied{
    background:#FCA5A5;
    color:#7F1D1D;
}

.vacant{
    background:#D9F99D;
    color:#14532D;
}

.legend{
    margin-top:18px;
    background:white;
    color:#111827;
    padding:12px;
    border-radius:10px;
    text-align:center;
    font-weight:700;
}

.assign-panel{
    background:linear-gradient(135deg,#1F6DB7,#2D7DD2);
    border-radius:20px;
    padding:20px;
}

.assign-title{
    background:white;
    color:#111827;
    padding:14px;
    border-radius:12px;
    font-weight:700;
    margin-bottom:20px;
    text-align:center;
}

.assign-content{
    background:#EEF2FF;
    border-radius:16px;
    padding:20px;
}

.assign-form{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
}

.assign-form input,
.assign-form select{
    padding:14px;
    border:none;
    border-radius:10px;
}

.assign-btn{
    margin-top:15px;
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#145DA0;
    color:white;
    font-weight:700;
    cursor:pointer;
}

.overview-title{
    margin-top:25px;
    margin-bottom:15px;
    background:white;
    color:#111827;
    padding:14px;
    border-radius:12px;
    font-weight:700;
    text-align:center;
}

.overview-box{
    background:white;
    border-radius:14px;
    padding:15px;
}

.overview-table{
    width:100%;
    border-collapse:collapse;
}

.overview-table th{
    background:#DBEAFE;
    padding:14px;
    text-align:left;
    color:#1E3A8A;
}

.overview-table td{
    padding:14px;
    border-bottom:1px solid #E5E7EB;
}

.badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-red{
    background:#FEE2E2;
    color:#991B1B;
}

.badge-green{
    background:#DCFCE7;
    color:#166534;
}

</style>

<div class="dashboard-wrapper">
    <div class="content-area">

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <h1>Ward & Bed Management</h1>
                <p>{{ now()->format('F d, Y | h:i A') }}</p>
            </div>
            <input type="text" placeholder="Search..." class="search-box">
        </div>

        <!-- ADD BUTTON -->
        <a href="{{ route('wards.create') }}" class="add-btn">+ Add Ward</a>

        <!-- STATS -->
        <div class="stats-grid">

            <div class="stat-card">
                <h3>TOTAL WARD</h3>
                <p>{{ $wards->count() }}</p>
            </div>

            <div class="stat-card">
                <h3>TOTAL BEDS</h3>
                <p>{{ $wards->sum('total_beds') }}</p>
            </div>

            <div class="stat-card">
                <h3>OCCUPIED BEDS</h3>
                <p>{{ \App\Models\BedAllocation::whereNull('actual_leave_date')->count() }}</p>
            </div>

            <div class="stat-card">
                <h3>VACANT ROOM</h3>
                <p>{{ $wards->sum('total_beds') - \App\Models\BedAllocation::whereNull('actual_leave_date')->count() }}</p>
            </div>

        </div>

        <!-- MAIN GRID -->
        <div class="main-grid">

            <!-- LEFT PANEL -->
            <div class="panel">

                <div class="panel-title">MAINTAIN WARD INFORMATION</div>

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
                    <a href="#" id="viewBtn">VIEW</a>
                    <a href="#" id="editBtn">EDIT</a>
                </div>

                <div class="ward-form">
                    <select><option id="wardName"></option></select>
                    <select><option id="wardLocation"></option></select>
                    <select><option id="wardCapacity"></option></select>
                    <select><option id="wardAvailable"></option></select>
                </div>

            </div>

            <!-- RIGHT PANEL -->
            <div class="panel">

                <div class="panel-title">TRACK OCCUPIED & VACANT BEDS</div>

                <div class="tabs">
                    @foreach($wards as $index => $ward)
                        <button
                            class="tab-btn {{ $index == 0 ? 'active' : '' }}"
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

                    <div
                        class="bed-grid ward-beds"
                        id="beds-{{ $ward->ward_id }}"
                        style="{{ $index != 0 ? 'display:none;' : '' }}">

                        @for($i = 1; $i <= $ward->total_beds; $i++)
                            <div class="bed {{ in_array($i, $occupiedBeds) ? 'occupied' : 'vacant' }}">
                                Bed {{ $i }}
                            </div>
                        @endfor

                    </div>
                @endforeach

                <div class="legend">
                    🟥 Occupied &nbsp;&nbsp;&nbsp; 🟩 Vacant
                </div>

            </div>

        </div>

        <!-- ASSIGN PANEL -->
        <div class="assign-panel">

            <div class="assign-title">ASSIGN BED TO ADMITTED PATIENT</div>

            <div class="assign-content">

                <form action="{{ route('bed-allocations.store') }}" method="POST">
                    @csrf

                    <div class="assign-form">

                        <input type="number"
                               name="patient_id"
                               placeholder="Patient ID"
                               required>

                        <select name="ward_id" required>
                            <option value="">Select Ward</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->ward_id }}">{{ $ward->ward_name }}</option>
                            @endforeach
                        </select>

                        <input type="number"
                               name="bed_number"
                               placeholder="Bed Number"
                               required>

                        <input type="date"
                               name="date_expected_leave">

                    </div>

                    <button type="submit" class="assign-btn">ASSIGN BED</button>

                </form>

                <!-- RECENT ASSIGNMENT -->
                <div class="overview-title">RECENT ASSIGNMENT</div>

                <div class="overview-box">

                    @php
                        $recentAllocations = \App\Models\BedAllocation::with(['ward', 'patient'])
                            ->latest()
                            ->take(5)
                            ->get();
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
                                    <td>
                                        {{ optional($allocation->patient)->first_name }}
                                        {{ optional($allocation->patient)->last_name }}
                                    </td>
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
                                    <td colspan="5" style="text-align:center; padding:25px;">
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
</div>

<script>

function changeWard() {
    let selector = document.getElementById('wardSelector');
    let selected = selector.options[selector.selectedIndex];

    document.getElementById('wardName').textContent     = selected.dataset.name;
    document.getElementById('wardLocation').textContent = selected.dataset.location;
    document.getElementById('wardCapacity').textContent = 'Capacity: ' + selected.dataset.capacity;
    document.getElementById('wardAvailable').textContent = 'Available: ' + selected.dataset.available;
    document.getElementById('viewBtn').href             = selected.dataset.view;
    document.getElementById('editBtn').href             = selected.dataset.edit;
}

changeWard();

function showBeds(wardId, btn) {
    document.querySelectorAll('.ward-beds').forEach(function(el) {
        el.style.display = 'none';
    });

    document.getElementById('beds-' + wardId).style.display = 'grid';

    document.querySelectorAll('.tab-btn').forEach(function(el) {
        el.classList.remove('active');
    });

    btn.classList.add('active');
}

</script>

@endsection