@extends('layouts.app')

@section('content')

<style>
    /* ── Page header ── */
    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px 14px;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }
    .dash-header-left h2 {
        font-size: 18px;
        font-weight: 700;
        color: #1a3a5c;
    }
    .dash-header-left p {
        font-size: 12px;
        color: #718096;
        margin-top: 2px;
    }
    .dash-header-actions { display: flex; gap: 10px; }

    /* ── Body padding ── */
    .dash-body { padding: 20px 24px; display: flex; flex-direction: column; gap: 20px; }

    /* ── Stat cards row ── */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .stat-label {
        font-size: 12px;
        color: #718096;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-icon { font-size: 15px; }
    .stat-value { font-size: 32px; font-weight: 700; color: #1a3a5c; line-height: 1; }
    .stat-delta { font-size: 12px; }
    .delta-up   { color: #22c55e; }
    .delta-down { color: #ef4444; }
    .delta-warn { color: #f59e0b; font-weight: 600; }

    /* ── Middle row ── */
    .mid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* ── Card shared ── */
    .dash-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 18px;
    }
    .dash-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .dash-card-title { font-size: 14px; font-weight: 600; color: #1a3a5c; }
    .dash-card-link  { font-size: 12px; color: #3b82f6; text-decoration: none; }

    /* ── Bar chart ── */
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 120px; }
    .bar-group { display: flex; flex-direction: column; align-items: center; gap: 3px; flex: 1; }
    .bar-pair  { display: flex; gap: 3px; align-items: flex-end; width: 100%; }
    .bar {
        flex: 1;
        border-radius: 4px 4px 0 0;
        min-height: 4px;
        transition: opacity .2s;
    }
    .bar:hover { opacity: .75; }
    .bar-admitted   { background: #3b82f6; }
    .bar-discharged { background: #bfdbfe; }
    .bar-label { font-size: 10px; color: #718096; margin-top: 4px; }
    .bar-legend { display: flex; gap: 14px; margin-top: 10px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 4px; }
    .legend-item { font-size: 11px; color: #718096; display: flex; align-items: center; }

    /* ── Ward occupancy ── */
    .ward-filter { display: flex; gap: 6px; }
    .ward-filter span {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 20px;
        cursor: pointer;
        background: #1a3a5c;
        color: #fff;
    }
    .ward-row { margin-bottom: 14px; }
    .ward-row-header {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #4a5568;
        margin-bottom: 4px;
    }
    .ward-pct { font-weight: 600; color: #ef4444; }
    .ward-bar-bg {
        background: #f0f4f8;
        border-radius: 4px;
        height: 6px;
        overflow: hidden;
    }
    .ward-bar-fill { height: 100%; border-radius: 4px; background: #ef4444; }
    .ward-sub { font-size: 11px; color: #718096; margin-top: 2px; }

    /* ── Bottom row ── */
    .bot-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

    /* ── Appointments table ── */
    .appt-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .appt-table th {
        text-align: left;
        padding: 6px 8px;
        color: #718096;
        font-weight: 500;
        border-bottom: 1px solid #e2e8f0;
    }
    .appt-table td { padding: 8px; border-bottom: 1px solid #f0f4f8; color: #2d3748; }
    .badge-done    { background: #dcfce7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 500; }
    .badge-waiting { background: #fef9c3; color: #713f12; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 500; }

    /* ── Doughnut chart ── */
    .donut-wrap { display: flex; align-items: center; gap: 18px; }
    .donut-legend { display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #4a5568; }
    .donut-legend-item { display: flex; align-items: center; gap: 6px; }
    .donut-dot { width: 10px; height: 10px; border-radius: 50%; }

    /* ── Quick actions ── */
    .quick-actions { display: flex; flex-direction: column; gap: 10px; }
    .qa-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 13px;
        color: #1a3a5c;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
    }
    .qa-btn:hover { background: #f0f4f8; }
    .qa-icon { font-size: 16px; }
</style>

{{-- ── Page Header ── --}}
<div class="dash-header">
    <div class="dash-header-left">
        <h2>Dashboard</h2>
        <p>{{ \Carbon\Carbon::today()->format('M d, Y') }} &middot; Module Overview</p>
    </div>
    <div class="dash-header-actions">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">+ Add Patient</a>
        <a href="{{ route('appointments.create') }}" class="btn">New Appointment</a>
    </div>
</div>

<div class="dash-body">

    {{-- ── Stat Cards ── --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-label">Total patients</div>
            <div class="stat-value">{{ $stats['total_patients'] }}</div>
            <div class="stat-delta delta-up">↑ {{ $stats['total_delta'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Admitted </div>
            <div class="stat-value">{{ $stats['admitted'] }}</div>
            <div class="stat-delta delta-up">↑ {{ $stats['admitted_delta'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Outpatients </div>
            <div class="stat-value">{{ $stats['outpatients'] }}</div>
            <div class="stat-delta delta-down">↓ {{ $stats['outpatients_delta'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Beds available</div>
            <div class="stat-value">{{ $stats['beds_available'] }}</div>
            <div class="stat-delta delta-warn">{{ $stats['beds_status'] }}</div>
        </div>
    </div>

    {{-- ── Middle Row: Chart + Ward Occupancy ── --}}
    <div class="mid-row">

        {{-- Bar Chart --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Patient admissions — last 7 days</span>
                <a href="#" class="dash-card-link">View report</a>
            </div>

            @php
                $maxVal = collect($admissionsChart)->map(fn($d) => max($d['admitted'], $d['discharged']))->max();
            @endphp

            <div class="bar-chart">
                @foreach($admissionsChart as $day)
                @php
                    $aH = $maxVal > 0 ? round(($day['admitted']   / $maxVal) * 100) : 0;
                    $dH = $maxVal > 0 ? round(($day['discharged'] / $maxVal) * 100) : 0;
                @endphp
                <div class="bar-group">
                    <div class="bar-pair" style="height:100px;">
                        <div class="bar bar-admitted"   style="height:{{ $aH }}px;" title="Admitted: {{ $day['admitted'] }}"></div>
                        <div class="bar bar-discharged" style="height:{{ $dH }}px;" title="Discharged: {{ $day['discharged'] }}"></div>
                    </div>
                    <div class="bar-label">{{ $day['day'] }}</div>
                </div>
                @endforeach
            </div>

            <div class="bar-legend">
                <span class="legend-item"><span class="legend-dot" style="background:#3b82f6;"></span> Admitted</span>
                <span class="legend-item"><span class="legend-dot" style="background:#bfdbfe;"></span> Discharged</span>
            </div>
        </div>

        {{-- Ward Occupancy --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Ward occupancy</span>
                <div class="ward-filter"><span>All wards</span></div>
            </div>

            @foreach($wards as $ward)
            <div class="ward-row">
                <div class="ward-row-header">
                    <span>{{ $ward['name'] }}</span>
                    <span class="ward-pct">{{ $ward['pct'] }}%</span>
                </div>
                <div class="ward-bar-bg">
                    <div class="ward-bar-fill" style="width:{{ $ward['pct'] }}%;
                        background: {{ $ward['pct'] >= 90 ? '#ef4444' : ($ward['pct'] >= 75 ? '#f59e0b' : '#3b82f6') }};"></div>
                </div>
                <div class="ward-sub">{{ $ward['occupied'] }} / {{ $ward['total'] }} beds</div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- ── Bottom Row: Appointments + Donut + Quick Actions ── --}}
    <div class="bot-row">

        {{-- Today's Appointments --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Today's appointments</span>
                <a href="{{ route('appointments.index') }}" class="dash-card-link">View all</a>
            </div>
            <table class="appt-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                    <tr>
                        <td>{{ $appt['patient'] }}</td>
                        <td>{{ $appt['doctor'] }}</td>
                        <td>
                            @if($appt['status'] === 'Done')
                                <span class="badge-done">Done</span>
                            @else
                                <span class="badge-waiting">Waiting</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Patient Type Breakdown (Doughnut) --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Patient type breakdown</span>
            </div>
            <div class="donut-wrap">
                <canvas id="donutChart" width="130" height="130"></canvas>
                <div class="donut-legend">
                    <div class="donut-legend-item">
                        <div class="donut-dot" style="background:#3b82f6;"></div>
                        Admitted &mdash; {{ $patientBreakdown['admitted'] }}
                    </div>
                    <div class="donut-legend-item">
                        <div class="donut-dot" style="background:#22c55e;"></div>
                        Outpatient &mdash; {{ $patientBreakdown['outpatient'] }}
                    </div>
                    <div class="donut-legend-item">
                        <div class="donut-dot" style="background:#f59e0b;"></div>
                        Discharged &mdash; {{ $patientBreakdown['discharged'] }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Quick actions</span>
            </div>
            <div class="quick-actions">
                <a href="{{ route('patients.create') }}" class="qa-btn">
                     Register patient
                </a>
                <a href="{{ route('patients.list') }}" class="qa-btn">
                     Transfer patient
                </a>
                <a href="{{ route('appointments.create') }}" class="qa-btn">
                     Schedule appointment
                </a>
                <a href="{{ route('wards.index') }}" class="qa-btn">
                     Manage beds
                </a>
            </div>
        </div>

    </div>

</div>

{{-- Donut chart via Canvas --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('donutChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    const data   = [{{ $patientBreakdown['admitted'] }}, {{ $patientBreakdown['outpatient'] }}, {{ $patientBreakdown['discharged'] }}];
    const colors = ['#3b82f6', '#22c55e', '#f59e0b'];
    const total  = data.reduce((a, b) => a + b, 0);

    const cx = canvas.width / 2, cy = canvas.height / 2;
    const outerR = 55, innerR = 34;
    let startAngle = -Math.PI / 2;

    data.forEach((val, i) => {
        const sweep = (val / total) * 2 * Math.PI;
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, outerR, startAngle, startAngle + sweep);
        ctx.closePath();
        ctx.fillStyle = colors[i];
        ctx.fill();
        startAngle += sweep;
    });

    // Cut inner hole
    ctx.beginPath();
    ctx.arc(cx, cy, innerR, 0, 2 * Math.PI);
    ctx.fillStyle = '#fff';
    ctx.fill();

    // Center label
    ctx.fillStyle = '#1a3a5c';
    ctx.font = 'bold 18px Segoe UI';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(total, cx, cy);
});
</script>

@endsection