@extends('layouts.app')

@section('title', 'Bed Allocations')

@section('content')

<style>
* { box-sizing: border-box; }

.ba-wrapper {
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #EAF1FB;
    min-height: 100vh;
}

/* ── Topbar ── */
.ba-topbar {
    background: #1a3451;
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ba-topbar-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ba-topbar-icon {
    font-size: 22px;
}
.ba-topbar h1 {
    font-size: 20px;
    font-weight: 700;
    color: white;
    letter-spacing: 0.5px;
    margin: 0;
}
.ba-topbar p {
    margin: 3px 0 0 0;
    color: #DBEAFE;
    font-size: 12px;
}
.ba-search-wrap {
    display: flex;
    gap: 8px;
    align-items: center;
}
.ba-search-wrap input {
    width: 240px;
    padding: 9px 14px;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    outline: none;
    background: white;
    color: #1E293B;
}
.ba-search-wrap button {
    padding: 9px 20px;
    background: #2D6DB5;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}
.ba-search-wrap button:hover { background: #1a3451; }

/* ── Stats ── */
.ba-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    padding: 20px 30px 0;
}
.ba-stat {
    background: #2D6DB5;
    border-radius: 14px;
    padding: 22px 24px;
    color: white;
}
.ba-stat h3 {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    opacity: 0.85;
    margin: 0 0 10px 0;
}
.ba-stat p {
    font-size: 36px;
    font-weight: 700;
    line-height: 1;
    margin: 0 0 6px 0;
}
.ba-stat span {
    font-size: 12px;
    opacity: 0.75;
}

/* ── Main content ── */
.ba-main {
    margin: 20px 30px 0;
    background: #2D6DB5;
    border-radius: 16px;
    padding: 18px;
}
.ba-section-title {
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

/* ── Table ── */
.ba-table-wrap {
    background: white;
    border-radius: 12px;
    overflow-x: auto;
}
.ba-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    min-width: 900px;
}
.ba-table thead th {
    background: #DBEAFE;
    color: #1E3A8A;
    padding: 13px 14px;
    text-align: left;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    white-space: nowrap;
}
.ba-table tbody td {
    padding: 13px 14px;
    border-bottom: 1px solid #F0F4FF;
    color: #1E293B;
    vertical-align: middle;
}
.ba-table tbody tr:last-child td { border-bottom: none; }
.ba-table tbody tr:hover { background: #F8FAFF; }

/* ── Badges ── */
.badge-occupied {
    background: #DCFCE7;
    color: #166534;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}
.badge-discharged {
    background: #FEE2E2;
    color: #991B1B;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}
.badge-waiting {
    background: #FEF3C7;
    color: #92400E;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}

/* ── Action buttons ── */
.btn-edit {
    background: #1a3451;
    color: white;
    padding: 6px 16px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    display: inline-block;
}
.btn-edit:hover { background: #243d5e; color: white; }
.btn-discharge {
    background: #DC2626;
    color: white;
    padding: 6px 14px;
    border-radius: 7px;
    border: none;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}
.btn-discharge:hover { background: #B91C1C; }

/* ── Alerts ── */
.ba-alert {
    margin: 16px 30px 0;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
}
.ba-alert-success { background: #D1FAE5; color: #065F46; }
.ba-alert-error   { background: #FEE2E2; color: #991B1B; }

/* ── Back button ── */
.ba-back-wrap {
    padding: 20px 30px 30px;
}
.ba-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1a3451;
    color: white;
    padding: 12px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
}
.ba-back-btn:hover { background: #243d5e; color: white; }

/* ── Pagination ── */
.ba-pagination {
    padding: 14px 0 0;
    display: flex;
    justify-content: flex-end;
}
</style>

<div class="ba-wrapper">

    {{-- TOPBAR --}}
    <div class="ba-topbar">
        <div class="ba-topbar-left">
            <div>
                <h1>BED ALLOCATIONS</h1>
                <p>{{ now()->format('F d, Y | h:i A') }}</p>
            </div>
        </div>
        <form method="GET" class="ba-search-wrap">
            <input type="text"
                   name="search"
                   value="{{ $search ?? '' }}"
                   placeholder="Search patient...">
            <button type="submit">Search</button>
        </form>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="ba-alert ba-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="ba-alert ba-alert-error">{{ session('error') }}</div>
    @endif

    {{-- STATS --}}
    <div class="ba-stats">
        <div class="ba-stat">
            <h3>Total Allocations</h3>
            <p>{{ $totalAllocations }}</p>
            <span>All records</span>
        </div>
        <div class="ba-stat">
            <h3>Occupied</h3>
            <p>{{ $occupied }}</p>
            <span>Currently admitted</span>
        </div>
        <div class="ba-stat">
            <h3>Discharged</h3>
            <p>{{ $discharged }}</p>
            <span>Left the ward</span>
        </div>
        <div class="ba-stat">
            <h3>On Waiting List</h3>
            <p>{{ $onWaitingList }}</p>
            <span>Pending bed assignment</span>
        </div>
    </div>

    {{-- TABLE PANEL --}}
    <div class="ba-main">
        <div class="ba-section-title">ALL BED ALLOCATIONS</div>

        <div class="ba-table-wrap">
            <table class="ba-table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Ward</th>
                        <th>Bed No.</th>
                        <th>Date Placed Waiting</th>
                        <th>Expected Duration (Days)</th>
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
                                    {{ $allocation->patient->first_name }} {{ $allocation->patient->last_name }}
                                </span>
                            @else
                                ID {{ $allocation->patient_id }}
                            @endif
                        </td>

                        <td>{{ $allocation->ward->ward_name ?? 'N/A' }}</td>

                        <td>Bed {{ $allocation->bed_number }}</td>

                        <td>
                            {{ $allocation->date_placed_waiting?->format('Y-m-d') ?? '—' }}
                        </td>

                        <td style="text-align:center;">
                            {{ $allocation->expected_duration_days ?? '—' }}
                        </td>

                        <td>
                            {{ $allocation->date_placed?->format('Y-m-d') ?? '—' }}
                        </td>

                        <td>
                            {{ $allocation->date_expected_leave?->format('Y-m-d') ?? '—' }}
                        </td>

                        <td>
                            @if($allocation->actual_leave_date)
                                <span style="color:#DC2626; font-weight:600;">
                                    {{ $allocation->actual_leave_date->format('Y-m-d') }}
                                </span>
                            @else
                                <span style="color:#9CA3AF;">—</span>
                            @endif
                        </td>

                        <td>
                            @if($allocation->actual_leave_date)
                                <span class="badge-discharged">Discharged</span>
                            @elseif($allocation->date_placed)
                                <span class="badge-occupied">Occupied</span>
                            @else
                                <span class="badge-waiting">On Waiting List</span>
                            @endif
                        </td>

                        <td style="white-space:nowrap; display:flex; gap:6px; align-items:center;">
                            <a href="{{ route('bed-allocations.edit', $allocation) }}" class="btn-edit">Edit</a>

                            @if(!$allocation->actual_leave_date)
                                <form action="{{ route('bed-allocations.discharge', $allocation) }}" method="POST"
                                      onsubmit="return confirm('Discharge this patient?');" style="margin:0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-discharge">Discharge</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" style="text-align:center; color:#94A3B8; padding:2.5rem;">
                            No bed allocations found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($allocations->hasPages())
            <div class="ba-pagination">
                {{ $allocations->links() }}
            </div>
        @endif

    </div>

    {{-- BACK BUTTON --}}
    <div class="ba-back-wrap">
        <a href="{{ route('wards.index') }}" class="ba-back-btn">
            ← Back to Ward &amp; Bed Management
        </a>
    </div>

</div>

@endsection