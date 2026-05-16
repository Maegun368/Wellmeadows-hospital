@extends('layouts.app')
@section('title', 'Appointments')
@section('hide-topbar', true)
@section('content')

<style>
/* ── Theme Variables ── */
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-accent: #2980b9;
    --blue-pale:   #d6eaf8;
    --green-bed:   #a9d64b;
    --white:       #ffffff;
    --text-white:  #ffffff;
    --text-dark:   #1a5276;
}

/* ── Page header ── */
.appt-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: var(--blue-dark);
    gap: 16px;
}
.appt-header h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
}
.appt-header-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
}
.appt-search {
    flex: 1;
    max-width: 380px;
    position: relative;
}
.appt-search input {
    width: 100%;
    padding: 9px 14px 9px 14px;
    border-radius: 8px;
    border: none;
    font-size: 13px;
    color: #2d3748;
    background: rgba(255,255,255,0.9);
}
.appt-search input::placeholder { color: #a0aec0; }
.appt-header-actions { display: flex; gap: 10px; }
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
.btn-outline-white {
    background: transparent;
    color: var(--white);
    border: 1px solid rgba(255,255,255,0.5);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background .15s;
}
.btn-outline-white:hover { background: rgba(255,255,255,0.1); }

/* ── Body ── */
.appt-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 20px 24px;
    align-items: start;
    background: #e8f4fd;
    min-height: calc(100vh - 60px);
}

/* ── Left panel ── */
.appt-left { display: flex; flex-direction: column; gap: 14px; }

/* Filter tags */
.filter-row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
.filter-label { font-size: 12px; color: var(--blue-dark); font-weight: 600; margin-right: 2px; }
.filter-tag {
    font-size: 11px;
    padding: 5px 14px;
    border-radius: 20px;
    border: 1px solid var(--blue-mid);
    background: var(--white);
    color: var(--blue-mid);
    cursor: pointer;
    font-weight: 500;
    transition: all .15s;
}
.filter-tag.active, .filter-tag:hover {
    background: var(--blue-dark);
    color: var(--white);
    border-color: var(--blue-dark);
}

/* Timeline list */
.timeline-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    padding: 18px 18px 10px;
}
.timeline-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--blue-pale);
}
.timeline-card-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--white);
    background: var(--blue-mid);
    padding: 6px 16px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.timeline { position: relative; padding-left: 24px; }
.timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 8px;
    bottom: 8px;
    width: 2px;
    background: var(--blue-pale);
    border-radius: 2px;
}
.timeline-item {
    position: relative;
    margin-bottom: 14px;
    cursor: pointer;
}
.timeline-item:last-child { margin-bottom: 0; }
.timeline-dot {
    position: absolute;
    left: -21px;
    top: 12px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #cbd5e0;
    background: #a0aec0;
}
.timeline-dot.done       { background: #27ae60; box-shadow: 0 0 0 2px #a9dfbf; }
.timeline-dot.waiting    { background: var(--blue-mid); box-shadow: 0 0 0 2px var(--blue-pale); }
.timeline-dot.overdue    { background: #e74c3c; box-shadow: 0 0 0 2px #fadbd8; }
.timeline-dot.out_patient { background: #8e44ad; box-shadow: 0 0 0 2px #d7bde2; }
.timeline-dot.admitted   { background: #e67e22; box-shadow: 0 0 0 2px #fde8d8; }

.timeline-box {
    background: #f0f8ff;
    border: 1px solid var(--blue-pale);
    border-radius: 8px;
    padding: 10px 14px;
    transition: all .15s;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.timeline-box:hover { background: var(--blue-pale); border-color: var(--blue-mid); }
.timeline-box.selected { background: #d6eaf8; border-color: var(--blue-dark); border-width: 2px; }

.tl-left { flex: 1; min-width: 0; }
.tl-patient { font-size: 13px; font-weight: 600; color: var(--blue-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.tl-sub     { font-size: 11px; color: var(--blue-mid); margin-top: 2px; }
.tl-right   { text-align: right; flex-shrink: 0; }
.tl-time    { font-size: 12px; font-weight: 600; color: var(--blue-dark); }
.tl-room    { font-size: 11px; color: var(--blue-mid); }

.tl-badge {
    display: inline-block;
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 600;
    margin-top: 4px;
}
.tl-badge-done       { background: #a9dfbf; color: #1e8449; }
.tl-badge-waiting    { background: var(--blue-pale); color: var(--blue-dark); }
.tl-badge-overdue    { background: #fadbd8; color: #c0392b; }
.tl-badge-out_patient { background: #d7bde2; color: #6c3483; }
.tl-badge-admitted   { background: #fde8d8; color: #a04000; }

.timeline-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}
.tl-btn {
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid var(--blue-mid);
    background: var(--white);
    color: var(--blue-dark);
    cursor: pointer;
    text-decoration: none;
    font-weight: 500;
    transition: background .15s;
}
.tl-btn:hover { background: var(--blue-pale); }
.tl-btn-danger  { border-color: #e74c3c; color: #c0392b; }
.tl-btn-danger:hover  { background: #fadbd8; }
.tl-btn-success { border-color: #27ae60; color: #1e8449; }
.tl-btn-success:hover { background: #a9dfbf; }

/* Pagination */
.appt-pagination { display: flex; justify-content: flex-end; padding: 8px 0 4px; }

/* ── Right panel ── */
.appt-right { display: flex; flex-direction: column; gap: 14px; }

/* Stat cards 2×2 */
.appt-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.appt-stat-card {
    background: var(--blue-mid);
    border-radius: 10px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.asc-label { font-size: 11px; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
.asc-value { font-size: 28px; font-weight: 700; color: var(--white); line-height: 1.1; }
.asc-sub   { font-size: 11px; color: rgba(255,255,255,0.7); }

/* Detail preview card */
.detail-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    padding: 18px;
}
.detail-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--blue-pale);
}
.detail-card-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--white);
    background: var(--blue-dark);
    padding: 6px 16px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.detail-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 160px;
    color: var(--blue-mid);
    font-size: 13px;
    gap: 8px;
    border: 2px dashed var(--blue-pale);
    border-radius: 8px;
    background: #f0f8ff;
}
.detail-placeholder span { font-size: 28px; }

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid var(--blue-pale);
    font-size: 13px;
}
.detail-row:last-child { border-bottom: none; }
.detail-key   { color: var(--blue-mid); font-weight: 500; }
.detail-val   { color: var(--blue-dark); font-weight: 600; }
.detail-actions { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; }

/* Quick link cards */
.quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.quick-link-card {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--blue-dark);
    border-radius: 10px;
    padding: 14px;
    text-decoration: none;
    transition: background .15s;
}
.quick-link-card:hover { background: var(--blue-mid); }
.ql-icon { font-size: 22px; }
.ql-title { font-size: 13px; font-weight: 600; color: var(--white); }
.ql-sub   { font-size: 11px; color: rgba(255,255,255,0.65); }

/* ── Outcome Modal ── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 30, 50, 0.55);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; }

.outcome-modal {
    background: var(--white);
    border-radius: 14px;
    width: 100%;
    max-width: 420px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    animation: slideUp .2s ease;
}
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

.outcome-modal-header {
    background: var(--blue-dark);
    padding: 16px 20px;
}
.outcome-modal-header h3 {
    color: var(--white);
    font-size: 14px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.outcome-modal-header p {
    color: rgba(255,255,255,0.65);
    font-size: 11px;
    margin: 4px 0 0;
}

.outcome-modal-body {
    padding: 24px 20px;
}
.outcome-patient-name {
    font-size: 13px;
    color: var(--blue-dark);
    font-weight: 600;
    margin-bottom: 18px;
    padding: 10px 14px;
    background: var(--blue-pale);
    border-radius: 8px;
}

.outcome-choices {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.outcome-choice-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px 14px;
    border-radius: 10px;
    border: 2px solid var(--blue-pale);
    background: #f8fbff;
    cursor: pointer;
    transition: all .15s;
    text-align: center;
}
.outcome-choice-btn:hover {
    border-color: var(--blue-mid);
    background: var(--blue-pale);
    transform: translateY(-2px);
}
.outcome-choice-btn .choice-icon { font-size: 28px; }
.outcome-choice-btn .choice-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--blue-dark);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.outcome-choice-btn .choice-desc {
    font-size: 10px;
    color: var(--blue-mid);
    line-height: 1.4;
}
.outcome-choice-btn.outpatient:hover { border-color: #8e44ad; background: #f5eef8; }
.outcome-choice-btn.admitted:hover   { border-color: #e67e22; background: #fef5ec; }

.outcome-modal-footer {
    padding: 12px 20px 16px;
    text-align: right;
    border-top: 1px solid var(--blue-pale);
}
.btn-modal-cancel {
    font-size: 12px;
    color: #7f8c8d;
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 6px;
    transition: background .15s;
}
.btn-modal-cancel:hover { background: #f0f0f0; }

/* hidden form used to submit outcome */
#outcome-form { display: none; }
</style>

{{-- ── Page Header ── --}}
<div class="appt-header">
    <div>
        <h2>Appointments</h2>
        <div class="appt-header-sub">{{ now()->format('F d, Y | h:i A') }}</div>
    </div>
    <div class="appt-search">
        <input type="text" id="apptSearch" placeholder="Search..." oninput="filterTimeline(this.value)">
    </div>
    <div class="appt-header-actions">
        <a href="{{ route('appointments.create') }}" class="btn-white">+ New Appointment</a>
    </div>
</div>

<div class="appt-body">

    {{-- ══ LEFT PANEL ══ --}}
    <div class="appt-left">

        {{-- Flash messages --}}
        @if(session('success'))
            <div style="background:#a9dfbf;color:#1e8449;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:600;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div style="background:#fde8d8;color:#a04000;padding:10px 16px;border-radius:8px;font-size:13px;font-weight:600;">
                ⚠ {{ session('warning') }}
            </div>
        @endif

        {{-- Filter tags --}}
        <div class="filter-row">
            <span class="filter-label">Filter:</span>
            <span class="filter-tag active" onclick="applyFilter('all', this)">All</span>
            <span class="filter-tag" onclick="applyFilter('today', this)">Today</span>
            <span class="filter-tag" onclick="applyFilter('waiting', this)">Waiting</span>
            <span class="filter-tag" onclick="applyFilter('done', this)">Done</span>
            <span class="filter-tag" onclick="applyFilter('overdue', this)">Overdue</span>
            <span class="filter-tag" onclick="window.location='?show=resolved'">Resolved</span>
        </div>

        {{-- Timeline list --}}
        <div class="timeline-card">
            <div class="timeline-card-header">
                <span class="timeline-card-title">Appointment Schedule</span>
            </div>

            <div class="timeline" id="timeline-list">
                @forelse($appointments as $appt)
                @php
                    $apptDateTime = \Carbon\Carbon::parse($appt->appointment_date . ' ' . $appt->appointment_time);
                    $isToday  = $apptDateTime->isToday();
                    $isPast   = $apptDateTime->isPast();

                    // If an outcome was already recorded, show that instead of done/overdue
                    if ($appt->outcome === 'out_patient') {
                        $statusClass = 'out_patient';
                        $statusLabel = 'Out-patient';
                    } elseif ($appt->outcome === 'admitted') {
                        $statusClass = 'admitted';
                        $statusLabel = 'Admitted';
                    } else {
                        $statusClass = $isPast && !$isToday ? 'overdue' : ($isPast ? 'done' : 'waiting');
                        $statusLabel = $isPast && !$isToday ? 'Overdue' : ($isPast ? 'Done' : 'Waiting');
                    }

                    $patientName = isset($appt->patient_first_name)
                        ? $appt->patient_first_name . ' ' . $appt->patient_last_name
                        : 'Patient #' . $appt->patient_id;
                    $doctorName = isset($appt->doctor_last_name)
                        ? 'Dr. ' . $appt->doctor_last_name
                        : 'Consultant #' . $appt->consultant_id;

                    // Show "Mark Done" button only for done/overdue appointments with no outcome yet
                    $canMarkDone = $isPast && $appt->outcome === null;
                @endphp
                <div class="timeline-item"
                     data-status="{{ $statusClass }}"
                     data-date="{{ $appt->appointment_date }}"
                     data-patient="{{ strtolower($patientName) }}"
                     data-doctor="{{ strtolower($doctorName) }}"
                     onclick="showDetail({{ json_encode([
                         'id'          => $appt->appointment_id,
                         'patient'     => $patientName,
                         'doctor'      => $doctorName,
                         'date'        => \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y'),
                         'time'        => \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A'),
                         'room'        => $appt->examination_room,
                         'status'      => $statusLabel,
                         'statusClass' => $statusClass,
                         'canMarkDone' => $canMarkDone,
                         'patientId'   => $appt->patient_id,
                         'editUrl'     => route('appointments.edit', $appt->appointment_id),
                         'delUrl'      => route('appointments.destroy', $appt->appointment_id),
                         'completeUrl' => route('appointments.complete', $appt->appointment_id),
                     ]) }})">

                    <div class="timeline-dot {{ $statusClass }}"></div>
                    <div class="timeline-box" id="tl-box-{{ $appt->appointment_id }}">
                        <div class="tl-left">
                            <div class="tl-patient">{{ $patientName }}</div>
                            <div class="tl-sub">{{ $doctorName }} &middot; {{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d') }}</div>
                            <span class="tl-badge tl-badge-{{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="tl-right">
                            <div class="tl-time">{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</div>
                            <div class="tl-room">{{ $appt->examination_room }}</div>
                        </div>
                        <div class="timeline-actions" onclick="event.stopPropagation()">
                            @if($canMarkDone)
                                <button type="button" class="tl-btn tl-btn-success"
                                    onclick="openOutcomeModal({{ json_encode([
                                        'id'          => $appt->appointment_id,
                                        'patient'     => $patientName,
                                        'completeUrl' => route('appointments.complete', $appt->appointment_id),
                                    ]) }})">✓</button>
                            @endif
                            <a href="{{ route('appointments.edit', $appt->appointment_id) }}" class="tl-btn">Edit</a>
                            <form method="POST" action="{{ route('appointments.destroy', $appt->appointment_id) }}" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="tl-btn tl-btn-danger"
                                    onclick="return confirm('Cancel this appointment?')">✕</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align:center;color:#5dade2;padding:2rem;font-size:13px">No appointments found.</div>
                @endforelse
            </div>

            <div class="appt-pagination">{{ $appointments->links() }}</div>
        </div>

    </div>

    {{-- ══ RIGHT PANEL ══ --}}
    <div class="appt-right">

        {{-- Quick links --}}
        <div class="quick-links">
            <a href="{{ route('patient-medications.index') }}" class="quick-link-card">
                <span class="ql-icon"></span>
                <div>
                    <div class="ql-title">Medications</div>
                    <div class="ql-sub">Manage prescriptions</div>
                </div>
            </a>
            <a href="{{ route('pharmaceuticals.index') }}" class="quick-link-card">
                <span class="ql-icon"></span>
                <div>
                    <div class="ql-title">Pharmaceuticals</div>
                    <div class="ql-sub">Drug inventory</div>
                </div>
            </a>
        </div>

        {{-- 2×2 Stat cards --}}
        <div class="appt-stat-grid">
            <div class="appt-stat-card">
                <div class="asc-label">Total appointments</div>
                <div class="asc-value">{{ $appointments->total() }}</div>
                <div class="asc-sub">This period</div>
            </div>
            <div class="appt-stat-card" style="background:var(--blue-dark);">
                <div class="asc-label">Today's schedule</div>
                <div class="asc-value">{{ $todayCount ?? '—' }}</div>
                <div class="asc-sub">Scheduled today</div>
            </div>
            <div class="appt-stat-card" style="background:var(--blue-dark);">
                <div class="asc-label">Waiting</div>
                <div class="asc-value">{{ $waitingCount ?? '—' }}</div>
                <div class="asc-sub">Upcoming</div>
            </div>
            <div class="appt-stat-card">
                <div class="asc-label">Completed</div>
                <div class="asc-value">{{ $doneCount ?? '—' }}</div>
                <div class="asc-sub">Done today</div>
            </div>
        </div>

        {{-- Detail preview card --}}
        <div class="detail-card" id="detail-card">
            <div class="detail-card-header">
                <span class="detail-card-title" id="detail-title">Appointment Details</span>
                <span style="font-size:12px;color:#5dade2" id="detail-hint">Click an appointment to view</span>
            </div>

            <div class="detail-placeholder" id="detail-placeholder">
                <span></span>
                Select an appointment from the list
            </div>

            <div id="detail-content" style="display:none">
                <div class="detail-row"><span class="detail-key">Patient</span><span class="detail-val" id="d-patient"></span></div>
                <div class="detail-row"><span class="detail-key">Doctor</span><span class="detail-val" id="d-doctor"></span></div>
                <div class="detail-row"><span class="detail-key">Date</span><span class="detail-val" id="d-date"></span></div>
                <div class="detail-row"><span class="detail-key">Time</span><span class="detail-val" id="d-time"></span></div>
                <div class="detail-row"><span class="detail-key">Room</span><span class="detail-val" id="d-room"></span></div>
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span id="d-status"></span>
                </div>
                <div class="detail-actions">
                    {{-- "Mark Done" — only shown when canMarkDone is true --}}
                    <button id="d-mark-done" type="button"
                        style="display:none;background:#27ae60;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;"
                        onclick="openOutcomeModal(window._currentAppt)">
                        ✓ Mark Done
                    </button>
                    <a id="d-edit" href="#" class="btn btn-primary"
                        style="font-size:13px;background:var(--blue-dark);border-color:var(--blue-dark);">✏ Edit</a>
                    <form id="d-del-form" method="POST" style="margin:0">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="font-size:13px"
                            onclick="return confirm('Cancel this appointment?')">✕ Cancel</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- ══ Outcome Modal ══ --}}
<div class="modal-overlay" id="outcome-modal" onclick="closeOutcomeModal(event)">
    <div class="outcome-modal">
        <div class="outcome-modal-header">
            <h3>Appointment Complete</h3>
            <p>What is the outcome of this examination?</p>
        </div>
        <div class="outcome-modal-body">
            <div class="outcome-patient-name" id="modal-patient-name"></div>
            <div class="outcome-choices">
                <button type="button" class="outcome-choice-btn outpatient" onclick="submitOutcome('out_patient')">
                    <span class="choice-label">Out-patient Clinic</span>
                    <span class="choice-desc">Patient will attend follow-up sessions at the clinic</span>
                </button>
                <button type="button" class="outcome-choice-btn admitted" onclick="submitOutcome('admitted')">
                    <span class="choice-label">Admit to Ward</span>
                    <span class="choice-desc">Place patient on ward waiting list for a bed</span>
                </button>
            </div>
        </div>
        <div class="outcome-modal-footer">
            <button type="button" class="btn-modal-cancel" onclick="document.getElementById('outcome-modal').classList.remove('open')">
                Cancel
            </button>
        </div>
    </div>
</div>

{{-- Hidden form that submits the outcome choice --}}
<form id="outcome-form" method="POST" action="">
    @csrf
    <input type="hidden" name="outcome" id="outcome-value">
</form>

<script>
// Holds the currently selected appointment data
window._currentAppt = null;

function showDetail(data) {
    window._currentAppt = data;

    document.getElementById('detail-placeholder').style.display = 'none';
    document.getElementById('detail-content').style.display     = 'block';
    document.getElementById('detail-hint').style.display        = 'none';
    document.getElementById('detail-title').textContent = 'Appointment #' + data.id;
    document.getElementById('d-patient').textContent    = data.patient;
    document.getElementById('d-doctor').textContent     = data.doctor;
    document.getElementById('d-date').textContent       = data.date;
    document.getElementById('d-time').textContent       = data.time;
    document.getElementById('d-room').textContent       = data.room;
    document.getElementById('d-edit').href              = data.editUrl;
    document.getElementById('d-del-form').action        = data.delUrl;

    const statusColors = {
        Done:       'tl-badge-done',
        Waiting:    'tl-badge-waiting',
        Overdue:    'tl-badge-overdue',
        'Out-patient': 'tl-badge-out_patient',
        Admitted:   'tl-badge-admitted',
    };
    const s = document.getElementById('d-status');
    s.innerHTML = `<span class="tl-badge ${statusColors[data.status] || ''}">${data.status}</span>`;

    // Show/hide "Mark Done" button based on whether the appointment can still be resolved
    document.getElementById('d-mark-done').style.display = data.canMarkDone ? '' : 'none';

    document.querySelectorAll('.timeline-box').forEach(b => b.classList.remove('selected'));
    const box = document.getElementById('tl-box-' + data.id);
    if (box) box.classList.add('selected');
}

function openOutcomeModal(data) {
    window._currentAppt = data;
    document.getElementById('modal-patient-name').textContent = '👤 ' + data.patient;
    document.getElementById('outcome-modal').classList.add('open');
}

function closeOutcomeModal(event) {
    // Only close if clicking directly on the overlay (not the modal box)
    if (event.target === document.getElementById('outcome-modal')) {
        document.getElementById('outcome-modal').classList.remove('open');
    }
}

function submitOutcome(outcome) {
    const form = document.getElementById('outcome-form');
    form.action = window._currentAppt.completeUrl;
    document.getElementById('outcome-value').value = outcome;
    form.submit();
}

function filterTimeline(q) {
    q = q.toLowerCase();
    document.querySelectorAll('.timeline-item').forEach(item => {
        const match = item.dataset.patient.includes(q) || item.dataset.doctor.includes(q);
        item.style.display = match ? '' : 'none';
    });
}

function applyFilter(type, el) {
    document.querySelectorAll('.filter-tag').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    const today = new Date().toISOString().slice(0, 10);
    document.querySelectorAll('.timeline-item').forEach(item => {
        let show = true;
        if (type === 'today')   show = item.dataset.date === today;
        if (type === 'waiting') show = item.dataset.status === 'waiting';
        if (type === 'done')    show = item.dataset.status === 'done';
        if (type === 'overdue') show = item.dataset.status === 'overdue';
        item.style.display = show ? '' : 'none';
    });
}
</script>

@endsection