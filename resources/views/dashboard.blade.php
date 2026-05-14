@extends('layouts.app')

@section('content')

<style>
    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px 14px;
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }
    .dash-header-left h2 { font-size: 18px; font-weight: 700; color: #1a3a5c; }
    .dash-header-left p  { font-size: 12px; color: #718096; margin-top: 2px; }
    .dash-header-actions { position: relative; }

    /* ── Quick Actions dropdown ── */
    .qa-menu-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 16px; background: #1a3a5c; color: #fff;
        border: none; border-radius: 8px; font-size: 13px;
        font-weight: 600; cursor: pointer; transition: background .15s;
    }
    .qa-menu-btn:hover { background: #14304f; }
    .qa-menu-btn svg   { transition: transform .2s; }
    .qa-menu-btn.open svg { transform: rotate(180deg); }

    .qa-dropdown {
        display: none; position: absolute; top: calc(100% + 8px); right: 0;
        background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,.10); min-width: 210px;
        z-index: 200; padding: 6px;
    }
    .qa-dropdown.open { display: block; }
    .qa-dropdown a {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 7px; font-size: 13px;
        color: #1a3a5c; text-decoration: none; transition: background .12s;
    }
    .qa-dropdown a:hover { background: #f0f4f8; }
    .qa-dropdown-divider { border: none; border-top: 1px solid #e2e8f0; margin: 4px 0; }

    /* ── Body ── */
    .dash-body { padding: 20px 24px; display: flex; flex-direction: column; gap: 20px; }

    /* ── Stat cards ── */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .stat-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
        padding: 16px; display: flex; flex-direction: column; gap: 6px;
    }
    .stat-label { font-size: 12px; color: #718096; }
    .stat-value { font-size: 32px; font-weight: 700; color: #1a3a5c; line-height: 1; }
    .stat-delta { font-size: 12px; }
    .delta-up   { color: #22c55e; }
    .delta-down { color: #ef4444; }
    .delta-warn { color: #f59e0b; font-weight: 600; }

    /* ── Rows ── */
    .mid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .bot-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* ── Card ── */
    .dash-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; }
    .dash-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .dash-card-title { font-size: 14px; font-weight: 600; color: #1a3a5c; }
    .dash-card-link  { font-size: 12px; color: #3b82f6; text-decoration: none; }

    /* ── Bar chart ── */
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 120px; }
    .bar-group { display: flex; flex-direction: column; align-items: center; gap: 3px; flex: 1; }
    .bar-pair  { display: flex; gap: 3px; align-items: flex-end; width: 100%; }
    .bar { flex: 1; border-radius: 4px 4px 0 0; min-height: 4px; transition: opacity .2s; }
    .bar:hover { opacity: .75; }
    .bar-admitted   { background: #3b82f6; }
    .bar-discharged { background: #bfdbfe; }
    .bar-label { font-size: 10px; color: #718096; margin-top: 4px; }
    .bar-legend { display: flex; gap: 14px; margin-top: 10px; }
    .legend-dot  { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 4px; }
    .legend-item { font-size: 11px; color: #718096; display: flex; align-items: center; }

    /* ── Ward occupancy ── */
    .ward-filter span { font-size: 11px; padding: 3px 10px; border-radius: 20px; cursor: pointer; background: #1a3a5c; color: #fff; }
    .ward-row { margin-bottom: 14px; }
    .ward-row-header { display: flex; justify-content: space-between; font-size: 12px; color: #4a5568; margin-bottom: 4px; }
    .ward-pct { font-weight: 600; color: #ef4444; }
    .ward-bar-bg   { background: #f0f4f8; border-radius: 4px; height: 6px; overflow: hidden; }
    .ward-bar-fill { height: 100%; border-radius: 4px; }
    .ward-sub { font-size: 11px; color: #718096; margin-top: 2px; }

    /* ── Appointments table ── */
    .appt-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .appt-table th { text-align: left; padding: 6px 8px; color: #718096; font-weight: 500; border-bottom: 1px solid #e2e8f0; }
    .appt-table td { padding: 8px; border-bottom: 1px solid #f0f4f8; color: #2d3748; }
    .badge-done    { background: #dcfce7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 500; }
    .badge-waiting { background: #fef9c3; color: #713f12; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 500; }

    /* ── Donut ── */
    .donut-wrap { display: flex; align-items: center; gap: 18px; }
    .donut-legend { display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #4a5568; }
    .donut-legend-item { display: flex; align-items: center; gap: 6px; }
    .donut-dot { width: 10px; height: 10px; border-radius: 50%; }

    /* ── Quick Actions card ── */
    .qa-btn {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 13px;
        color: #1a3a5c;
        text-decoration: none;
        transition: background .15s;
    }
    .qa-btn:hover { background: #f0f4f8; }
</style>

{{-- ── Page Header ── --}}
<div class="dash-header">
    <div class="dash-header-left">
        <h2>Dashboard</h2>
        <p>{{ \Carbon\Carbon::today()->format('M d, Y') }} &middot; Module Overview</p>
    </div>
    <div class="dash-header-actions">
        <button class="qa-menu-btn" id="qaMenuBtn" onclick="toggleQaMenu()">
            Quick Actions
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
        <div class="qa-dropdown" id="qaDropdown">
            <a href="{{ route('patients.create') }}">Register patient</a>
            <a href="{{ route('patients.list') }}">Transfer patient</a>
            <hr class="qa-dropdown-divider">
            <a href="{{ route('appointments.create') }}">Schedule appointment</a>
            <a href="{{ route('wards.index') }}">Manage beds</a>
        </div>
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
            <div class="stat-label">Admitted</div>
            <div class="stat-value">{{ $stats['admitted'] }}</div>
            <div class="stat-delta delta-up">↑ {{ $stats['admitted_delta'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Outpatients</div>
            <div class="stat-value">{{ $stats['outpatients'] }}</div>
            <div class="stat-delta delta-down">↓ {{ $stats['outpatients_delta'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Beds available</div>
            <div class="stat-value">{{ $stats['beds_available'] }}</div>
            <div class="stat-delta delta-warn">{{ $stats['beds_status'] }}</div>
        </div>
    </div>

    {{-- ── Middle Row ── --}}
    <div class="mid-row">

        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Patient Admissions</span>
             
            </div>
            @php $maxVal = collect($admissionsChart)->map(fn($d) => max($d['admitted'], $d['discharged']))->max(); @endphp
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

        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Ward occupancy</span>
            </div>
            @foreach($wards as $ward)
            <div class="ward-row">
                <div class="ward-row-header">
                    <span>{{ $ward['name'] }}</span>
                    <span class="ward-pct">{{ $ward['pct'] }}%</span>
                </div>
                <div class="ward-bar-bg">
                    <div class="ward-bar-fill" style="width:{{ $ward['pct'] }}%; background:{{ $ward['pct'] >= 90 ? '#ef4444' : ($ward['pct'] >= 75 ? '#f59e0b' : '#3b82f6') }};"></div>
                </div>
                <div class="ward-sub">{{ $ward['occupied'] }} / {{ $ward['total'] }} beds</div>
            </div>
            @endforeach
        </div>

    </div>

    {{-- ── Bottom Row ── --}}
    <div class="bot-row">

        {{-- Today's Appointments --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Today's appointments</span>
                <a href="{{ route('appointments.index') }}" class="dash-card-link">View all</a>
            </div>
            <table class="appt-table">
                <thead><tr><th>Patient</th><th>Doctor</th><th>Status</th></tr></thead>
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

        {{-- Patient Type Breakdown --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Patient type breakdown</span>
            </div>
            <div class="donut-wrap">
                <canvas id="donutChart" width="130" height="130"></canvas>
                <div class="donut-legend">
                    <div class="donut-legend-item"><div class="donut-dot" style="background:#3b82f6;"></div> Admitted &mdash; {{ $patientBreakdown['admitted'] }}</div>
                    <div class="donut-legend-item"><div class="donut-dot" style="background:#22c55e;"></div> Outpatient &mdash; {{ $patientBreakdown['outpatient'] }}</div>
                    <div class="donut-legend-item"><div class="donut-dot" style="background:#f59e0b;"></div> Discharged &mdash; {{ $patientBreakdown['discharged'] }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

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
        const sweep = total > 0 ? (val / total) * 2 * Math.PI : 0;
        ctx.beginPath(); ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, outerR, startAngle, startAngle + sweep);
        ctx.closePath(); ctx.fillStyle = colors[i]; ctx.fill();
        startAngle += sweep;
    });
    ctx.beginPath(); ctx.arc(cx, cy, innerR, 0, 2 * Math.PI);
    ctx.fillStyle = '#fff'; ctx.fill();
    ctx.fillStyle = '#1a3a5c'; ctx.font = 'bold 18px Segoe UI';
    ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
    ctx.fillText(total, cx, cy);
});

function toggleQaMenu() {
    document.getElementById('qaMenuBtn').classList.toggle('open');
    document.getElementById('qaDropdown').classList.toggle('open');
}

document.addEventListener('click', function (e) {
    const btn = document.getElementById('qaMenuBtn');
    const dd  = document.getElementById('qaDropdown');
    if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
        btn.classList.remove('open');
        dd.classList.remove('open');
    }
});
</script>

@endsection