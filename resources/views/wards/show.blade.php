@extends('layouts.app')

@section('title', 'Ward Details')

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

/* ───── TOPBAR ───── */
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

.wbm-back-btn{
    background:rgba(255,255,255,.15);
    border:1px solid rgba(255,255,255,.3);
    color:white;
    padding:9px 16px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
}

.wbm-back-btn:hover{
    background:rgba(255,255,255,.25);
}

/* ───── STATS ───── */
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

/* ───── CONTENT ───── */
.wbm-content{
    padding:20px 24px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.wbm-content-full{
    padding:0 24px 0;
}

/* ───── PANEL ───── */
.wbm-panel{
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
}

.wbm-panel-body{
    padding:16px;
}

/* ───── PATIENT CARD ───── */
.patient-card{
    background:#f0f8ff;
    border-left:4px solid var(--blue-mid);
    padding:14px 16px;
    border-radius:8px;
    margin-bottom:12px;
}

.patient-card.waiting{
    background:#fffbeb;
    border-left-color:#f59e0b;
}

.patient-card h4{
    margin:0 0 8px 0;
    color:var(--blue-dark);
    font-size:15px;
    font-weight:700;
}

.patient-card p{
    margin:3px 0;
    color:#334155;
    font-size:13px;
}

/* ───── BED GRID ───── */
.bed-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
}

.bed{
    padding:16px 10px;
    border-radius:8px;
    text-align:center;
    font-weight:700;
    font-size:12px;
}

.occupied{
    background:#fca5a5;
    color:#7f1d1d;
}

.vacant{
    background:#bbf7d0;
    color:#14532d;
}

/* ───── BADGES ───── */
.badge{
    display:inline-block;
    padding:4px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

.badge-occupied{
    background:#d5f5e3;
    color:#1e8449;
}

.badge-waiting{
    background:#fef9c3;
    color:#854d0e;
}

.badge-discharged{
    background:#fadbd8;
    color:#c0392b;
}
/* ───── BACK BUTTON ROW ───── */
.wbm-back-row{
    padding:0 16px 16px;
    display:flex;
    justify-content:flex-start;
}

.wbm-back-row a{
    background:var(--blue-dark);
    color:white;
    padding:9px 18px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    display:inline-block;
}

.wbm-back-row a:hover{
    opacity:.9;
}

/* ───── RESPONSIVE ───── */
@media(max-width:1100px){
    .wbm-stats{ grid-template-columns:1fr 1fr; }
}

@media(max-width:768px){
    .wbm-content{ grid-template-columns:1fr; }
    .wbm-stats{ grid-template-columns:1fr; }
    .wbm-topbar{ flex-direction:column; align-items:flex-start; }
}
</style>

<div class="wbm-wrapper">

    {{-- TOPBAR --}}
    <div class="wbm-topbar">
        <div>
            <h1>🏥 {{ $ward->ward_name }}</h1>
            <p>{{ $ward->location }}</p>
        </div>
        <a href="{{ route('wards.index') }}" class="wbm-back-btn">← Back to Ward Management</a>
    </div>

    {{-- STATS --}}
    <div class="wbm-stats">
        <div class="wbm-stat">
            <h3>Total Beds</h3>
            <p>{{ $ward->total_beds }}</p>
            <span>Capacity</span>
        </div>
        <div class="wbm-stat">
            <h3>Occupied Beds</h3>
            <p>{{ $currentPatients->count() }}</p>
            <span>Currently admitted</span>
        </div>
        <div class="wbm-stat">
            <h3>Available Beds</h3>
            <p>{{ $availableBeds }}</p>
            <span>Ready to assign</span>
        </div>
        <div class="wbm-stat">
            <h3>Telephone Ext.</h3>
            <p style="font-size:22px;">{{ $ward->telephone_extension }}</p>
            <span>Extension number</span>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="wbm-content">

        {{-- CURRENT PATIENTS --}}
        <div class="wbm-panel">
            <div class="wbm-panel-title">Current Patients</div>
            <div class="wbm-panel-body">
                @forelse($currentPatients as $allocation)
                    <div class="patient-card">
                        <h4>
                            @if($allocation->patient)
                                {{ $allocation->patient->first_name }}
                                {{ $allocation->patient->last_name }}
                                <span style="font-size:12px;font-weight:500;color:#64748b;">
                                    (ID {{ $allocation->patient_id }})
                                </span>
                            @else
                                Patient ID: {{ $allocation->patient_id }}
                            @endif
                        </h4>
                        @if($allocation->patient?->phone)
                            <p>📞 {{ $allocation->patient->phone }}</p>
                        @endif
                        <p>🛏️ Bed {{ $allocation->bed_number }}</p>
                        <p>📅 Date Placed:
                            {{ \Carbon\Carbon::parse($allocation->date_placed)->format('F d, Y') }}
                        </p>
                        <div style="margin-top:8px;">
                            <span class="badge badge-occupied">Occupied</span>
                        </div>
                    </div>
                @empty
                    <p style="color:#94a3b8;text-align:center;padding:24px 0;">
                        No active patients found.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- BED MAP --}}
        <div class="wbm-panel">
            <div class="wbm-panel-title">Bed Occupancy Map</div>
            <div class="wbm-panel-body">
                <div class="bed-grid">
                    @foreach($bedMap as $bedNumber => $allocation)
                        <div class="bed {{ $allocation ? 'occupied' : 'vacant' }}">
                            Bed {{ $bedNumber }}
                            @if($allocation?->patient)
                                <div style="font-size:10px;margin-top:6px;font-weight:600;line-height:1.2;">
                                    {{ $allocation->patient->first_name }}
                                    {{ \Illuminate\Support\Str::substr($allocation->patient->last_name, 0, 1) }}.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:16px;display:flex;gap:8px;">
                    <span class="badge badge-discharged">Occupied</span>
                    <span class="badge badge-occupied">Vacant</span>
                </div>
            </div>
        </div>

    </div>

    {{-- WAITING LIST --}}
    @if($waitingList->isNotEmpty())
        <div class="wbm-content-full" style="margin-bottom:20px;">
            <div class="wbm-panel">
                <div class="wbm-panel-title">Waiting List</div>
                <div class="wbm-panel-body">
                    @foreach($waitingList as $allocation)
                        <div class="patient-card waiting">
                            <h4>
                                @if($allocation->patient)
                                    {{ $allocation->patient->first_name }}
                                    {{ $allocation->patient->last_name }}
                                    <span style="font-size:12px;font-weight:500;color:#64748b;">
                                        (ID {{ $allocation->patient_id }})
                                    </span>
                                @else
                                    Patient ID: {{ $allocation->patient_id }}
                                @endif
                            </h4>
                            <p>⏳ Waiting since:
                                {{ $allocation->date_placed_waiting
                                    ? $allocation->date_placed_waiting->format('F d, Y')
                                    : '—' }}
                            </p>
                            <div style="margin-top:8px;">
                                <span class="badge badge-waiting">On Waiting List</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
            </div>
            
        </div>
        {{-- BACK BUTTON (below table) --}}
            <div class="wbm-back-row">
                <a href="{{ route('wards.index') }}">← Back to Ward & Bed Management</a>
            </div>
    @endif

</div>

@endsection