@extends('layouts.app')

@section('title', 'Staff Details')

@section('content')

<style>
:root {
    --blue-dark:  #1a5276;
    --blue-mid:   #2e86c1;
    --blue-light: #5dade2;
    --blue-pale:  #d6eaf8;
    --blue-bg:    #e8f4fd;
    --white:      #ffffff;
}

/* ── Page wrapper ── */
.show-wrapper {
    min-height: calc(100vh - 60px);
    background: var(--blue-bg);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* ── Top action bar ── */
.show-actions {
    width: 100%;
    max-width: 780px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}
.show-actions-left { display: flex; gap: 8px; }
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    cursor: pointer;
    text-decoration: none;
    transition: opacity .15s;
    border: none;
}
.btn-action:hover { opacity: 0.85; }
.btn-back    { background: var(--blue-dark); color: var(--white); }
.btn-edit    { background: var(--blue-mid);  color: var(--white); }
.btn-delete  { background: var(--white); color: #c0392b; border: 1px solid #e74c3c; }
.btn-delete:hover { background: #fadbd8; opacity: 1; }
.btn-print   { background: var(--white); color: var(--blue-dark); border: 1px solid var(--blue-mid); }

/* ── Staff Form card ── */
.staff-form-card {
    width: 100%;
    max-width: 780px;
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(26,82,118,0.08);
}

/* Card header */
.sfc-header {
    background: var(--blue-dark);
    padding: 18px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sfc-header-left { display: flex; align-items: center; gap: 16px; }
.sfc-avatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    border: 2px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: var(--white); font-weight: 700;
    flex-shrink: 0;
}
.sfc-name {
    font-size: 20px; font-weight: 700; color: var(--white);
    letter-spacing: 0.01em; line-height: 1.2;
}
.sfc-role { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 3px; }
.sfc-id-badge {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 8px;
    padding: 8px 18px;
    text-align: center;
}
.sfc-id-label { font-size: 10px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.07em; }
.sfc-id-value { font-size: 17px; font-weight: 700; color: var(--white); margin-top: 2px; }

/* Card body */
.sfc-body { padding: 0; }

/* Section blocks */
.sfc-section {
    padding: 20px 28px;
    border-bottom: 1px solid var(--blue-pale);
}
.sfc-section:last-child { border-bottom: none; }
.sfc-section-title {
    font-size: 11px;
    font-weight: 700;
    color: var(--blue-mid);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 14px;
    padding-bottom: 6px;
    border-bottom: 1px solid var(--blue-pale);
}

/* Info grid */
.info-grid {
    display: grid;
    gap: 0;
}
.info-grid-2 { grid-template-columns: 1fr 1fr; }
.info-grid-3 { grid-template-columns: 1fr 1fr 1fr; }
.info-item {
    padding: 8px 12px;
    border: 1px solid var(--blue-pale);
    margin: -1px 0 0 -1px; /* collapse borders */
    background: var(--white);
}
.info-item:nth-child(odd) { background: #f7fbff; }
.info-label {
    font-size: 10px;
    font-weight: 700;
    color: var(--blue-mid);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 3px;
}
.info-value {
    font-size: 13px;
    color: #2d3748;
    font-weight: 500;
}
.info-value.empty { color: #a0aec0; font-style: italic; }

/* Contract badge */
.contract-badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
}
.badge-permanent  { background: #d5f5e3; color: #1e8449; }
.badge-temporary  { background: #fdebd0; color: #935116; }
.badge-fulltime   { background: var(--blue-pale); color: var(--blue-dark); }
.badge-parttime   { background: #f2f3f4; color: #566573; }

/* Tables for qual / work exp */
.sfc-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.sfc-table thead tr {
    background: var(--blue-dark);
}
.sfc-table thead th {
    padding: 9px 14px;
    color: var(--white);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: left;
}
.sfc-table tbody tr:nth-child(even) { background: #f7fbff; }
.sfc-table tbody tr:hover { background: var(--blue-pale); }
.sfc-table tbody td {
    padding: 10px 14px;
    border-bottom: 1px solid var(--blue-pale);
    color: #2d3748;
    vertical-align: middle;
}
.sfc-table tbody tr:last-child td { border-bottom: none; }
.empty-msg {
    text-align: center;
    color: var(--blue-light);
    font-size: 13px;
    padding: 18px;
    font-style: italic;
}

/* Print styles */
@media print {
    * { margin: 0; padding: 0; }
    body { background: white; }
    .show-actions { display: none; }
    .show-wrapper { padding: 20px; background: white; min-height: auto; }
    .staff-form-card { box-shadow: none; border: 1px solid #999; }
    
    /* Hide all layout elements except the form */
    nav { display: none !important; }
    header { display: none !important; }
    aside { display: none !important; }
    .sidebar { display: none !important; }
    .navbar { display: none !important; }
    .topbar { display: none !important; }
    .layout-sidebar { display: none !important; }
    
    .print-header {
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-bottom: 30px;
        padding: 20px;
        border-bottom: 3px solid var(--blue-dark);
        page-break-after: avoid;
    }
    
    .print-header-logo {
        width: 80px;
        height: auto;
    }
    
    .print-header-text {
        text-align: center;
    }
    
    .print-header-hospital-name {
        font-size: 28px;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
    }
    
    .print-header-subtitle {
        font-size: 12px;
        color: #666;
        margin: 5px 0 0 0;
    }
    
    .print-document-title {
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 20px 0 10px 0;
        page-break-after: avoid;
    }
    
    .print-date {
        text-align: center;
        font-size: 11px;
        color: #666;
        margin-bottom: 20px;
    }
}

/* Hide print section on screen */
.print-header { display: none; }

@media screen {
    .print-only { display: none !important; }
}
</style>

<div class="show-wrapper">

    {{-- ── Print Header ── --}}
    <div class="print-header print-only">
        <img src="{{ asset('image/wellmeadows-logo.png') }}" alt="Hospital Logo" class="print-header-logo">
        <div class="print-header-text">
            <h1 class="print-header-hospital-name">WELLMEADOWS HOSPITAL</h1>
            <p class="print-header-subtitle">Staff Information Record</p>
        </div>
    </div>
    <p class="print-date print-only">Document printed: {{ now()->format('d M Y \\a\\t H:i') }}</p>

    {{-- ── Action bar ── --}}
    <div class="show-actions">
        <div class="show-actions-left">
            <a href="{{ route('staff.index') }}" class="btn-action btn-back">Back</a>
            <a href="{{ route('staff.edit', $staff->staff_id) }}" class="btn-action btn-edit">Edit</a>
            <form action="{{ route('staff.destroy', $staff->staff_id) }}" method="POST"
                  onsubmit="return confirm('Delete this staff member?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action btn-delete">Delete</button>
            </form>
        </div>
        <button onclick="window.print()" class="btn-action btn-print">Print</button>
    </div>

    {{-- ── Staff Form Card ── --}}
    <div class="staff-form-card">

        {{-- Header --}}
        <div class="sfc-header">
            <div class="sfc-header-left">
                @php
                    $initials = strtoupper(
                        substr($staff->first_name ?? '', 0, 1) .
                        substr($staff->last_name  ?? '', 0, 1)
                    );
                @endphp
                <div class="sfc-avatar">{{ $initials }}</div>
                <div>
                    <div class="sfc-name">{{ $staff->first_name }} {{ $staff->last_name }}</div>
                    <div class="sfc-role">
                        {{ $staff->position }}
                        @if($staff->ward_name ?? false)
                            &bull; {{ $staff->ward_name }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="sfc-id-badge">
                <div class="sfc-id-label">Staff Number</div>
                <div class="sfc-id-value">{{ $staff->staff_id }}</div>
            </div>
        </div>

        <div class="sfc-body">

            {{-- ── Personal Details ── --}}
            <div class="sfc-section">
                <div class="sfc-section-title">Personal Details</div>
                <div class="info-grid info-grid-3">
                    <div class="info-item">
                        <div class="info-label">First Name</div>
                        <div class="info-value">{{ $staff->first_name ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Last Name</div>
                        <div class="info-value">{{ $staff->last_name ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date of Birth</div>
                        <div class="info-value">
                            {{ $staff->date_of_birth
                                ? \Carbon\Carbon::parse($staff->date_of_birth)->format('d M Y')
                                : '—' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Sex</div>
                        <div class="info-value">{{ $staff->sex ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tel. No.</div>
                        <div class="info-value">{{ $staff->phone ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">NIN</div>
                        <div class="info-value">{{ $staff->NIN ?? '—' }}</div>
                    </div>
                </div>
                <div class="info-grid" style="grid-template-columns:1fr; margin-top: -1px;">
                    <div class="info-item" style="background:#f7fbff;">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $staff->address ?? '—' }}</div>
                    </div>
                </div>
            </div>

            {{-- ── Employment Details ── --}}
            <div class="sfc-section">
                <div class="sfc-section-title">Employment Details</div>
                <div class="info-grid info-grid-3">
                    <div class="info-item">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $staff->position ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Allocated to Ward</div>
                        <div class="info-value">{{ $staff->ward_name ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Current Salary (₱)</div>
                        <div class="info-value">
                            {{ $staff->current_salary
                                ? '₱ ' . number_format($staff->current_salary, 2)
                                : '—' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Salary Scale</div>
                        <div class="info-value">{{ $staff->salary_scale ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Hours / Week</div>
                        <div class="info-value">
                            {{ $staff->hours_per_week ? $staff->hours_per_week . ' hrs' : '—' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Pay Type</div>
                        <div class="info-value">{{ $staff->pay_type ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Contract Type</div>
                        <div class="info-value">
                            @if($staff->contract_type === 'Full-time')
                                <span class="contract-badge badge-fulltime">Full-time</span>
                            @elseif($staff->contract_type === 'Part-time')
                                <span class="contract-badge badge-parttime">Part-time</span>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Permanent or Temporary</div>
                        <div class="info-value">
                            @php
                                $isPermanent = $staff->contract_type === 'Full-time';
                            @endphp
                            <span class="contract-badge {{ $isPermanent ? 'badge-permanent' : 'badge-temporary' }}">
                                {{ $isPermanent ? 'Permanent' : 'Temporary' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Qualifications ── --}}
            <div class="sfc-section">
                <div class="sfc-section-title">Qualifications</div>
                @if($staff->qualifications->count())
                    <table class="sfc-table">
                        <thead>
                            <tr>
                                <th>Qualification Type</th>
                                <th>Date Obtained</th>
                                <th>Institution</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff->qualifications as $q)
                            <tr>
                                <td>{{ $q->type ?? '—' }}</td>
                                <td>
                            {{ $q->date_obtained
                                ? \Carbon\Carbon::parse($q->date_obtained)->format('d M Y')
                                : '—' }}
                                </td>
                                <td>{{ $q->institution ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-msg">No qualifications recorded.</div>
                @endif
            </div>

            {{-- ── Work Experience ── --}}
            <div class="sfc-section">
                <div class="sfc-section-title">Work Experience</div>
                @if($staff->workExperiences->count())
                    <table class="sfc-table">
                        <thead>
                            <tr>
                                <th>Position / Role</th>
                                <th>Organization</th>
                                <th>Start Date</th>
                                <th>Finish Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff->workExperiences as $w)
                            <tr>
                                <td>{{ $w->position ?? '—' }}</td>
                                <td>{{ $w->organization_name ?? '—' }}</td>
                                <td>{{ $w->start_date ?? '—' }}</td>
                                <td>{{ $w->finish_date ?? 'Present' }}</td>
                                <td>
                                    @if($w->finish_date)
                                        {{ \Carbon\Carbon::parse($w->finish_date)->format('d M Y') }}
                                    @else
                                        <span class="contract-badge badge-permanent">Present</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-msg">No work experience recorded.</div>
                @endif
            </div>

        </div>{{-- /sfc-body --}}
    </div>{{-- /staff-form-card --}}

</div>{{-- /show-wrapper --}}

@endsection