@extends('layouts.app')

@section('content')

<style>
    .pm-wrap {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background: #e8f0fb;
    }

    /* ── TOPBAR ── */
    .pm-topbar {
        background: #1a3560;
        padding: 14px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .pm-topbar h1 {
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        margin: 0;
    }
    .pm-topbar p {
        color: rgba(255,255,255,0.5);
        font-size: 11px;
        margin: 2px 0 0;
    }
    .pm-topbar-actions { display: flex; gap: 10px; }
    .pm-btn {
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        border: none;
    }
    .pm-btn-white { background: #fff; color: #1a3560; }
    .pm-btn-white:hover { background: #dce8f5; color: #1a3560; }
    .pm-btn-blue  { background: #1565c0; color: #fff; }
    .pm-btn-blue:hover  { background: #0d47a1; color: #fff; }

    /* ── CONTENT ── */
    .pm-content { flex: 1; padding: 20px 28px; }

    .pm-add-btn {
        padding: 7px 16px;
        background: #1565c0;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        margin-bottom: 16px;
    }
    .pm-add-btn:hover { background: #0d47a1; color: #fff; }

    /* ── STATS ── */
    .pm-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }
    .pm-stat { border-radius: 8px; padding: 14px 16px; }
    .pm-stat-label {
        font-size: 11px;
        color: rgba(255,255,255,0.85);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }
    .pm-stat-val  { font-size: 28px; font-weight: 500; color: #fff; }
    .pm-stat-sub  { font-size: 11px; color: rgba(255,255,255,0.7); margin-top: 4px; }

    /* ── GRIDS ── */
    .pm-grid-top { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .pm-grid-bot { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }

    /* ── FEATURE CARDS ── */
    .pm-feat {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border: 0.5px solid #90b8e0;
    }
    .pm-feat-head {
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #1565c0;
        flex-shrink: 0;
    }
    .pm-feat-title { font-size: 13px; font-weight: 500; color: #fff; }
    .pm-feat-badge { font-size: 10.5px; padding: 3px 9px; border-radius: 20px; font-weight: 500; }
    .badge-white-pill { background: rgba(255,255,255,0.2); color: #fff; }
    .badge-green-pill { background: #4caf50; color: #fff; }

    .pm-feat-body { flex: 1; padding: 12px 14px; overflow: hidden; }
    .pm-feat-foot {
        padding: 9px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 0.5px solid #d0e4f5;
        background: #f0f7ff;
        flex-shrink: 0;
    }
    .pm-see-more {
        padding: 5px 16px;
        border: 0.5px solid #90b8e0;
        border-radius: 20px;
        font-size: 11.5px;
        color: #1565c0;
        background: #fff;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
    }
    .pm-see-more:hover { background: #e8f0fb; color: #1565c0; }
    .pm-feat-count { font-size: 11px; color: #5b80a0; }

    /* ── MINI TABLE ── */
    .mini-tbl { width: 100%; border-collapse: collapse; }
    .mini-tbl th {
        text-align: left;
        color: #5b80a0;
        font-weight: 500;
        padding: 0 4px 7px;
        border-bottom: 0.5px solid #d0e4f5;
        font-size: 11px;
    }
    .mini-tbl td {
        padding: 6px 4px;
        color: #1a3560;
        border-bottom: 0.5px solid #eef4fb;
        font-size: 11.5px;
    }
    .mini-tbl tr:last-child td { border-bottom: none; }
    .sp { display: inline-block; padding: 2px 7px; border-radius: 20px; font-size: 10px; font-weight: 500; }
    .sp-ward     { background: #dbeafe; color: #1e40af; }   /* has ward = admitted */
    .sp-noward   { background: #f3f4f6; color: #6b7280; }   /* no ward  = discharged */
    .sp-outpatient { background: #dcfce7; color: #15803d; }

    /* ── BAR CHART ── */
    .bar-chart-wrap {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 100px;
        padding: 0 2px;
    }
    .bar-col { display: flex; flex-direction: column; align-items: center; flex: 1; gap: 3px; }
    .bar-fill { width: 100%; border-radius: 4px 4px 0 0; }
    .bar-lbl  { font-size: 10px; color: #5b80a0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 36px; }
    .bar-num  { font-size: 10px; color: #1a3560; font-weight: 500; }

    /* ── ACTIVITY FEED ── */
    .act-list  { display: flex; flex-direction: column; gap: 9px; }
    .act-item  { display: flex; align-items: flex-start; gap: 9px; }
    .act-dot   { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 3px; }
    .act-text  { font-size: 11.5px; color: #1a3560; line-height: 1.4; }
    .act-time  { font-size: 10px; color: #90a8c0; margin-top: 1px; }

    /* ── STATUS BARS ── */
    .st-rows { display: flex; flex-direction: column; gap: 10px; }
    .st-row  { display: flex; flex-direction: column; gap: 4px; }
    .st-top  { display: flex; justify-content: space-between; font-size: 11.5px; }
    .st-name { color: #1a3560; font-weight: 500; }
    .st-num  { color: #5b80a0; }
    .st-bg   { height: 7px; background: #e8f0fb; border-radius: 4px; overflow: hidden; }
    .st-fill { height: 100%; border-radius: 4px; }

    .empty-msg { font-size: 12px; color: #90a8c0; text-align: center; padding: 14px 0; }
</style>

<div class="pm-wrap">

    {{-- TOPBAR --}}
    <div class="pm-topbar">
        <div>
            <h1>Patient Management</h1>
            <p>{{ now()->format('M d, Y | h:i A') }} &nbsp;|&nbsp; Module 1</p>
        </div>
        <div class="pm-topbar-actions">
            <a href="{{ route('patients.create') }}" class="pm-btn pm-btn-white">+ Register</a>
            <a href="{{ route('patients.list') }}"  class="pm-btn pm-btn-blue">View All</a>
        </div>
    </div>

    <div class="pm-content">

        <a href="{{ route('patients.create') }}" class="pm-add-btn">+ Add Patient</a>

        {{-- STAT CARDS --}}
        <div class="pm-stats">
            <div class="pm-stat" style="background:#5b9bd5;">
                <div class="pm-stat-label">Total Patients</div>
                <div class="pm-stat-val">{{ $totalPatients }}</div>
                <div class="pm-stat-sub">All records</div>
            </div>
            <div class="pm-stat" style="background:#4a8ec9;">
                <div class="pm-stat-label">Admitted</div>
                <div class="pm-stat-val">{{ $admitted }}</div>
                <div class="pm-stat-sub">Has ward assigned</div>
            </div>
            <div class="pm-stat" style="background:#3d82c4;">
                <div class="pm-stat-label">Outpatients</div>
                <div class="pm-stat-val">{{ $outpatients }}</div>
                <div class="pm-stat-sub">Outpatient visits</div>
            </div>
            <div class="pm-stat" style="background:#2e74b5;">
                <div class="pm-stat-label">No Ward</div>
                <div class="pm-stat-val">{{ $discharged }}</div>
                <div class="pm-stat-sub">Not admitted</div>
            </div>
        </div>

        {{-- TOP ROW --}}
        <div class="pm-grid-top">

            {{-- Box 1: Patient Medical Records table --}}
            <div class="pm-feat">
                <div class="pm-feat-head">
                    <span class="pm-feat-title">Patient Medical Records</span>
                    <span class="pm-feat-badge badge-white-pill">Recent</span>
                </div>
                <div class="pm-feat-body">
                    <table class="mini-tbl">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Ward</th>
                                <th>Blood</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPatients as $p)
                            <tr>
                                <td>{{ $p->first_name }} {{ $p->last_name }}</td>
                                <td>{{ $p->ward ?: '—' }}</td>
                                <td>{{ $p->blood_type ?? 'N/A' }}</td>
                                <td>
                                    @if($p->ward)
                                        <span class="sp sp-ward">Admitted</span>
                                    @else
                                        <span class="sp sp-noward">No Ward</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="empty-msg">No records yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pm-feat-foot">
                    <span class="pm-feat-count">{{ $totalPatients }} total records</span>
                    <a href="{{ route('patients.list') }}" class="pm-see-more">See More</a>
                </div>
            </div>

            {{-- Box 2: Ward bar chart --}}
            <div class="pm-feat">
                <div class="pm-feat-head">
                    <span class="pm-feat-title">Assign Patient to Wards and Bed</span>
                    <span class="pm-feat-badge badge-green-pill">{{ $freeBeds }} free beds</span>
                </div>
                <div class="pm-feat-body">
                    <div style="font-size:11px;color:#5b80a0;margin-bottom:8px;">Patients per ward</div>
                    @if($wardStats->count())
                    @php
                        $colors = ['#5b9bd5','#4a8ec9','#3d82c4','#2e74b5','#1565c0','#0d47a1'];
                        $maxVal = $wardStats->max('count') ?: 1;
                    @endphp
                    <div class="bar-chart-wrap">
                        @foreach($wardStats as $i => $w)
                        <div class="bar-col">
                            <div class="bar-num">{{ $w->count }}</div>
                            <div class="bar-fill"
                                 style="height:{{ max(8, round(($w->count / $maxVal) * 90)) }}px;
                                        background:{{ $colors[$i % count($colors)] }};"></div>
                            <div class="bar-lbl" title="{{ $w->ward_name }}">
                                {{ Str::limit($w->ward_name, 5, '') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="empty-msg">No ward assignments yet</p>
                    @endif
                </div>
                <div class="pm-feat-foot">
                    <span class="pm-feat-count">{{ $wardStats->count() }} ward(s)</span>
                    <a href="{{ route('wards.index') }}" class="pm-see-more">See More</a>
                </div>
            </div>

        </div>

        {{-- BOTTOM ROW --}}
        <div class="pm-grid-bot">

            {{-- Box 3: Patient list compact table --}}
            <div class="pm-feat">
                <div class="pm-feat-head">
                    <span class="pm-feat-title">View Patient List</span>
                    <span class="pm-feat-badge badge-white-pill">{{ $totalPatients }}</span>
                </div>
                <div class="pm-feat-body">
                    <table class="mini-tbl">
                        <thead>
                            <tr><th>ID</th><th>Name</th><th>Age</th><th>Ward</th></tr>
                        </thead>
                        <tbody>
                           @forelse($recentPatients->take(4) as $p)
<tr>
    <td>#{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</td>
    <td>{{ Str::limit($p->first_name.' '.$p->last_name, 16) }}</td>
    <td>{{ $p->date_of_birth ? \Carbon\Carbon::parse($p->date_of_birth)->age : '—' }}</td>
    <td>{{ $p->ward ?: '—' }}</td>
</tr>
@empty
<tr><td colspan="4" class="empty-msg">No patients yet</td></tr>
@endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pm-feat-foot">
                    <span class="pm-feat-count">All patients</span>
                    <a href="{{ route('patients.list') }}" class="pm-see-more">See More</a>
                </div>
            </div>

            {{-- Box 4: Next of kin activity feed --}}
            <div class="pm-feat">
                <div class="pm-feat-head">
                    <span class="pm-feat-title">Next of Kin</span>
                    <span class="pm-feat-badge badge-white-pill">Recent</span>
                </div>
                <div class="pm-feat-body">
                    @if($recentKin->count())
                    <div class="act-list">
                        @foreach($recentKin as $kin)
                        @php
                            $dotColors = ['#5b9bd5','#4caf50','#f59e0b','#2e74b5'];
                            $ci = $loop->index % 4;
                        @endphp
                        <div class="act-item">
                            <div class="act-dot" style="background:{{ $dotColors[$ci] }};"></div>
                            <div>
                                <div class="act-text">
                                    <strong>{{ $kin->name }}</strong>
                                    ({{ $kin->relationship }})
                                   — for {{ $kin->patient_first_name ?? 'patient' }}
{{ $kin->patient_last_name ?? '' }}
                                </div>
                                <div class="act-time">
                                    {{ $kin->phone }}
                                    &nbsp;·&nbsp;
                                    {{ optional($kin->created_at)->diffForHumans() ?? '—' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="empty-msg">No next of kin records yet</p>
                    @endif
                </div>
                <div class="pm-feat-foot">
                    <span class="pm-feat-count">Contact records</span>
                    <a href="{{ route('patients.list') }}" class="pm-see-more">See More</a>
                </div>
            </div>

            {{-- Box 5: Discharge / status breakdown --}}
            <div class="pm-feat">
                <div class="pm-feat-head">
                    <span class="pm-feat-title">Discharge Details</span>
                    <span class="pm-feat-badge badge-white-pill">{{ $discharged }} no ward</span>
                </div>
                <div class="pm-feat-body">
                    @php $total = max($totalPatients, 1); @endphp
                    <div class="st-rows">
                        <div class="st-row">
                            <div class="st-top">
                                <span class="st-name">Admitted (has ward)</span>
                                <span class="st-num">{{ $admitted }} / {{ $totalPatients }}</span>
                            </div>
                            <div class="st-bg">
                                <div class="st-fill"
                                     style="width:{{ round(($admitted/$total)*100) }}%;
                                            background:#5b9bd5;"></div>
                            </div>
                        </div>
                        <div class="st-row">
                            <div class="st-top">
                                <span class="st-name">Outpatient visits</span>
                                <span class="st-num">{{ $outpatients }}</span>
                            </div>
                            <div class="st-bg">
                                <div class="st-fill"
                                     style="width:{{ $totalPatients ? min(100, round(($outpatients/$total)*100)) : 0 }}%;
                                            background:#4caf50;"></div>
                            </div>
                        </div>
                        <div class="st-row">
                            <div class="st-top">
                                <span class="st-name">No ward assigned</span>
                                <span class="st-num">{{ $discharged }} / {{ $totalPatients }}</span>
                            </div>
                            <div class="st-bg">
                                <div class="st-fill"
                                     style="width:{{ round(($discharged/$total)*100) }}%;
                                            background:#f59e0b;"></div>
                            </div>
                        </div>
                        <div class="st-row">
                            <div class="st-top">
                                <span class="st-name">Avg. days admitted</span>
                                <span class="st-num">{{ $avgStay ?? '—' }} days</span>
                            </div>
                            <div class="st-bg">
                                <div class="st-fill"
                                     style="width:{{ $avgStay ? min(100, round(($avgStay/30)*100)) : 0 }}%;
                                            background:#2e74b5;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pm-feat-foot">
                    <span class="pm-feat-count">Patient breakdown</span>
                    <a href="{{ route('patients.list') }}" class="pm-see-more">See More</a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection