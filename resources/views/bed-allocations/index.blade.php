@extends('layouts.app')

@section('title', 'Bed Allocations')

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

.wbm-topbar-right{
    display:flex;
    gap:10px;
    align-items:center;
}

.wbm-topbar input{
    background:rgba(255,255,255,.15);
    border:1px solid rgba(255,255,255,.25);
    border-radius:8px;
    padding:8px 14px;
    font-size:13px;
    color:white;
    width:220px;
}

.wbm-topbar input::placeholder{
    color:rgba(255,255,255,.5);
}

.wbm-topbar input:focus{
    outline:none;
    background:rgba(255,255,255,.2);
}

.wbm-topbar button{
    background:white;
    color:var(--blue-dark);
    border:none;
    padding:9px 18px;
    border-radius:8px;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
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

/* ───── MAIN CONTENT PANEL ───── */
.wbm-content{
    padding:20px 24px;
}

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

/* ───── ALERTS ───── */
.wbm-alert{
    margin:16px 16px 0;
    padding:10px 14px;
    border-radius:8px;
    font-size:13px;
}

.wbm-alert-error{
    background:#fee2e2;
    color:#991b1b;
}

.wbm-alert-success{
    background:#d1fae5;
    color:#065f46;
}

/* ───── TABLE ───── */
.wbm-table-wrap{
    padding:16px;
    overflow-x:auto;
}

.wbm-table{
    width:100%;
    border-collapse:collapse;
    font-size:13px;
    min-width:1000px;
}

.wbm-table th{
    background:#f0f8ff;
    color:var(--blue-dark);
    text-align:left;
    padding:10px 14px;
    font-size:11px;
    font-weight:700;
    text-transform:uppercase;
    border-bottom:2px solid var(--blue-pale);
}

.wbm-table td{
    padding:12px 14px;
    border-bottom:1px solid #eef4ff;
    vertical-align:middle;
}

.wbm-table tr:last-child td{
    border-bottom:none;
}

.wbm-table tbody tr:hover{
    background:#f8fbff;
}

/* ───── BADGES ───── */
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

/* ───── ACTION BUTTONS ───── */
.wbm-btn{
    padding:6px 14px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
    border:none;
    display:inline-block;
}

.wbm-btn-edit{
    background:var(--blue-dark);
    color:white;
}

.wbm-btn-edit:hover{
    opacity:.9;
}

.wbm-btn-discharge{
    background:#c0392b;
    color:white;
}

.wbm-btn-discharge:hover{
    opacity:.9;
}

.wbm-action-cell{
    display:flex;
    gap:6px;
    align-items:center;
    white-space:nowrap;
}

/* ───── EMPTY STATE ───── */
.wbm-empty{
    text-align:center;
    padding:40px;
    color:#94a3b8;
}

/* ───── PAGINATION ───── */
.wbm-pagination{
    padding:12px 16px 16px;
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
    .wbm-stats{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:768px){
    .wbm-stats{
        grid-template-columns:1fr;
    }

    .wbm-topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .wbm-topbar-right{
        flex-wrap:wrap;
    }
}
</style>

<div class="wbm-wrapper">

    {{-- TOPBAR --}}
    <div class="wbm-topbar">
        <div>
            <h1>🛏️ Bed Allocations</h1>
            <p>{{ now()->format('F d, Y | h:i A') }}</p>
        </div>
        <div class="wbm-topbar-right">
            <form method="GET" style="display:flex; gap:8px; align-items:center;">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Search patient...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $total      = $allocations->total();
        $occupied   = \App\Models\BedAllocation::whereNull('actual_leave_date')->whereNotNull('date_placed')->count();
        $discharged = \App\Models\BedAllocation::whereNotNull('actual_leave_date')->count();
        $waiting    = \App\Models\BedAllocation::whereNotNull('date_placed_waiting')->whereNull('date_placed')->whereNull('actual_leave_date')->count();
    @endphp
    <div class="wbm-stats">
        <div class="wbm-stat">
            <h3>Total Allocations</h3>
            <p>{{ $total }}</p>
            <span>All records</span>
        </div>
        <div class="wbm-stat">
            <h3>Occupied</h3>
            <p>{{ $occupied }}</p>
            <span>Currently admitted</span>
        </div>
        <div class="wbm-stat">
            <h3>Discharged</h3>
            <p>{{ $discharged }}</p>
            <span>Left the ward</span>
        </div>
        <div class="wbm-stat">
            <h3>On Waiting List</h3>
            <p>{{ $waiting }}</p>
            <span>Pending bed assignment</span>
        </div>
    </div>

    {{-- MAIN PANEL --}}
    <div class="wbm-content">
        <div class="wbm-panel">
            <div class="wbm-panel-title">All Bed Allocations</div>

            {{-- ALERTS --}}
            @if(session('error'))
                <div class="wbm-alert wbm-alert-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="wbm-alert wbm-alert-success">{{ session('success') }}</div>
            @endif

            {{-- TABLE --}}
            <div class="wbm-table-wrap">
                <table class="wbm-table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Ward</th>
                            <th>Bed No.</th>
                            <th>Date Placed Waiting</th>
                            <th>Expected Duration (days)</th>
                            <th>Date Placed</th>
                            <th>Expected Leave</th>
                            <th>Actual Leave Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allocations as $allocation)
                            <tr>
                                <td>{{ $allocation->patient_id }}</td>

                                <td>
                                    @if($allocation->patient)
                                        <span style="font-weight:600;">
                                            {{ $allocation->patient->first_name }}
                                            {{ $allocation->patient->last_name }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;">Unknown Patient</span>
                                    @endif
                                </td>

                                <td>{{ $allocation->ward->ward_name ?? 'N/A' }}</td>

                                <td>Bed {{ $allocation->bed_number }}</td>

                                <td>{{ $allocation->date_placed_waiting?->format('Y-m-d') ?? '—' }}</td>

                                <td style="text-align:center;">
                                    {{ $allocation->expected_duration_days ?? '—' }}
                                </td>

                                <td>{{ $allocation->date_placed?->format('Y-m-d') ?? '—' }}</td>

                                <td>{{ $allocation->date_expected_leave?->format('Y-m-d') ?? '—' }}</td>

                                <td>
                                    @if($allocation->actual_leave_date)
                                        <span style="color:#92400e; font-weight:600;">
                                            {{ $allocation->actual_leave_date->format('Y-m-d') }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if($allocation->actual_leave_date)
                                        <span class="badge-discharged">Discharged</span>
                                    @elseif($allocation->date_placed_waiting && !$allocation->date_placed)
                                        <span class="badge-waiting">On Waiting List</span>
                                    @else
                                        <span class="badge-occupied">Occupied</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="wbm-action-cell">
                                        <a href="{{ route('bed-allocations.edit', $allocation) }}"
                                           class="wbm-btn wbm-btn-edit">Edit</a>

                                        @if(!$allocation->actual_leave_date)
                                            <form action="{{ route('bed-allocations.discharge', $allocation) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Discharge this patient?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="wbm-btn wbm-btn-discharge">
                                                    Discharge
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">
                                    <div class="wbm-empty">No bed allocations found.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="wbm-pagination">
                {{ $allocations->links() }}
            </div>
        </div>
    </div>
    {{-- BACK BUTTON (below table) --}}
            <div class="wbm-back-row">
                <a href="{{ route('wards.index') }}">← Back to Ward & Bed Management</a>
            </div>

</div>

@endsection