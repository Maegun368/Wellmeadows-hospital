@extends('layouts.app')

@section('title', 'Patient Management')

@section('hide-topbar', true)

@section('content')

<style>
/* ── Theme Variables ── */
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-pale:   #d6eaf8;
    --white:       #ffffff;
    --text-dark:   #1a5276;
}

/* ── Page header ── */
.pm-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: var(--blue-dark);
    gap: 16px;
}
.pm-header h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
}
.pm-header-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
}
.pm-header-actions { display: flex; gap: 10px; }
.btn-white {
    background: var(--white);
    color: var(--blue-dark);
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity .15s;
}
.btn-white:hover { opacity: 0.9; }

/* ── Body ── */
.pm-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 20px 24px;
    align-items: start;
    background: #e8f4fd;
    min-height: calc(100vh - 60px);
}

/* ── Stat cards ── */
.pm-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px; }
.pm-stat-card {
    background: var(--blue-mid);
    border-radius: 10px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.psc-label { font-size: 11px; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
.psc-value { font-size: 28px; font-weight: 700; color: var(--white); line-height: 1.1; }
.psc-sub   { font-size: 11px; color: rgba(255,255,255,0.7); }

/* ── Dashboard cards ── */
.dashboard-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
}
.dashboard-card-header {
    background: var(--blue-mid);
    color: white;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.dashboard-card-body { padding: 14px 16px; }
.dashboard-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.dashboard-table thead tr { background: #f0f8ff; }
.dashboard-table th {
    padding: 8px 10px;
    text-align: left;
    font-weight: 600;
    color: var(--blue-mid);
    font-size: 11px;
    text-transform: uppercase;
}
.dashboard-table td {
    padding: 8px 10px;
    border-bottom: 1px solid var(--blue-pale);
    color: #2d3748;
}
.dashboard-table tbody tr:hover { background: #f0f8ff; }
.dashboard-table tbody tr:last-child td { border-bottom: none; }
.empty-msg {
    text-align: center;
    color: var(--blue-light);
    padding: 20px;
    font-style: italic;
    font-size: 12px;
}
.btn-link {
    color: var(--blue-mid);
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
    font-size: 11px;
}
.btn-link:hover { text-decoration: underline; }
.badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
}
.badge-green { background: #d1fae5; color: #065f46; }
.badge-blue { background: var(--blue-pale); color: var(--blue-dark); }

/* ── Left panel ── */
.pm-left { display: flex; flex-direction: column; gap: 14px; }

/* ── Right panel ── */
.pm-right { display: flex; flex-direction: column; gap: 14px; }

.detail-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--blue-pale); font-size: 12px; }
.detail-item:last-child { border-bottom: none; }
.detail-label { font-weight: 600; color: var(--blue-dark); }
.detail-value { color: #2d3748; }
.detail-value.number { color: var(--blue-mid); font-weight: 600; }
</style>

{{-- Page Header --}}
<div class="pm-header">
    <div>
        <h2>Patient Management</h2>
        <div class="pm-header-sub">{{ now()->format('M d, Y | H:i A') }} | Module 1</div>
    </div>
    <div class="pm-header-actions">
        @can('create patients')
            <a href="{{ route('patients.create') }}" class="btn-white">+ Register</a>
        @endcan
        @can('view patients')
            <a href="{{ route('patients.list') }}" class="btn-white">View All</a>
        @endcan
    </div>
</div>

{{-- Main Body --}}
<div class="pm-body">

    {{-- LEFT PANEL --}}
    <div class="pm-left">
        
        {{-- Stat Cards --}}
        <div class="pm-stat-grid">
            <div class="pm-stat-card">
                <div class="psc-label">Total Patients</div>
                <div class="psc-value">{{ $totalPatients }}</div>
                <div class="psc-sub">All records</div>
            </div>
            <div class="pm-stat-card">
                <div class="psc-label">Admitted</div>
                <div class="psc-value">{{ $admitted }}</div>
                <div class="psc-sub">Has ward assigned</div>
            </div>
            <div class="pm-stat-card">
                <div class="psc-label">Outpatients</div>
                <div class="psc-value">{{ $outpatients }}</div>
                <div class="psc-sub">Outpatient visits</div>
            </div>
            <div class="pm-stat-card">
                <div class="psc-label">No Ward</div>
                <div class="psc-value">{{ $noWard }}</div>
                <div class="psc-sub">Not admitted</div>
            </div>
        </div>

        {{-- Patient Medical Records --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span>Patient Medical Records</span>
                <a class="btn-link">Recent</a>
            </div>
            <div class="dashboard-card-body">
                @if($patients->count() > 0)
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Ward</th>
                                <th>Blood</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients->take(5) as $patient)
                            <tr>
                                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td>{{ $patient->bedAllocations->first()?->ward->ward_name ?? '—' }}</td>
                                <td>{{ $patient->blood_type ?? '—' }}</td>
                                <td><span class="badge badge-green">Active</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="empty-msg">No records yet</p>
                @endif
                <div style="text-align: center; margin-top: 12px;">
                    <a href="{{ route('patients.index') }}" class="btn-link">See More</a>
                </div>
            </div>
        </div>

        {{-- View Patient List --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span>View Patient List</span>
                <span style="background: rgba(255,255,255,0.2); padding: 3px 8px; border-radius: 4px; font-size: 10px;">{{ $totalPatients }}</span>
            </div>
            <div class="dashboard-card-body">
                @if($patients->count() > 0)
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Ward</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients->take(5) as $patient)
                            <tr>
                                <td>{{ $patient->id }}</td>
                                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td>{{ $patient->age ?? '—' }}</td>
                                <td>{{ $patient->bedAllocations->first()?->ward->ward_name ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="empty-msg">No patients yet</p>
                @endif
                <div style="text-align: center; margin-top: 12px;">
                    <a href="{{ route('patients.index') }}" class="btn-link">All patients</a>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT PANEL --}}
    <div class="pm-right">

        {{-- Assign Patient to Wards and Bed --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span>Assign Patient to Wards and Bed</span>
                <span style="background: #4ade80; color: white; padding: 3px 8px; border-radius: 4px; font-size: 10px;">0 free beds</span>
            </div>
            <div class="dashboard-card-body">
                <p style="text-align: center; color: var(--blue-light); padding: 20px; font-size: 12px;">Patients per ward</p>
                <p class="empty-msg">No ward assignments yet</p>
                <div style="text-align: center; margin-top: 12px;">
                    <a href="{{ route('bed-allocations.index') }}" class="btn-link">See More</a>
                </div>
            </div>
        </div>

        {{-- Next of Kin --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span>Next of Kin</span>
                <a class="btn-link">Recent</a>
            </div>
            <div class="dashboard-card-body">
                @if($nextOfKins->count() > 0)
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Relation</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nextOfKins as $kin)
                            <tr>
                                <td>{{ $kin->patient->first_name ?? '—' }}</td>
                                <td>{{ $kin->relationship ?? '—' }}</td>
                                <td>{{ $kin->phone_number ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="empty-msg">No next of kin records yet</p>
                @endif
                <div style="text-align: center; margin-top: 12px;">
                    <a href="#" class="btn-link">Contact records</a>
                </div>
            </div>
        </div>

        {{-- Discharge Details --}}
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                Discharge Details
                <span style="background: rgba(255,255,255,0.2); padding: 3px 8px; border-radius: 4px; font-size: 10px;">0 no ward</span>
            </div>
            <div class="dashboard-card-body">
                <div class="detail-item">
                    <span class="detail-label">Admitted (has ward)</span>
                    <span class="detail-value">0 / 0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Outpatient visits</span>
                    <span class="detail-value number">0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">No ward assigned</span>
                    <span class="detail-value">0 / 0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Avg. days admitted</span>
                    <span class="detail-value">— days</span>
                </div>
                <div style="text-align: center; margin-top: 12px;">
                    <a href="#" class="btn-link">See More</a>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection