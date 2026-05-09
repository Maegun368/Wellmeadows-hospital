@extends('layouts.app')

@section('title', 'Ward Details')

@section('content')

<style>

.page-wrapper{
    padding:25px;
    font-family:'Segoe UI',sans-serif;
}

/* HEADER */

.header-box{
    background:linear-gradient(135deg,#0D3B66,#145DA0);
    color:white;
    padding:35px;
    border-radius:20px;
    margin-bottom:25px;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

.header-box h1{
    margin:0;
    font-size:40px;
    font-weight:800;
    color:white;
}

.header-box p{
    margin-top:8px;
    color:#DBEAFE;
    font-size:16px;
}

/* STATS */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

.stat-card h3{
    font-size:14px;
    color:#64748B;
    margin-bottom:12px;
}

.stat-card p{
    font-size:34px;
    font-weight:700;
    color:#0D3B66;
}

/* MAIN GRID */

.main-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

/* PANEL */

.panel{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

.panel-title{
    font-size:24px;
    font-weight:700;
    color:#0D3B66;
    margin-bottom:20px;
}

/* PATIENT CARD */

.patient-card{
    background:#EFF6FF;
    border-left:5px solid #2563EB;
    padding:18px;
    border-radius:14px;
    margin-bottom:14px;
}

.patient-card h4{
    margin:0 0 10px 0;
    color:#1E3A8A;
    font-size:18px;
}

.patient-card p{
    margin:4px 0;
    color:#334155;
}

/* BED GRID */

.bed-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
}

.bed{
    padding:20px;
    border-radius:12px;
    text-align:center;
    font-weight:700;
    font-size:14px;
}

.occupied{
    background:#FCA5A5;
    color:#7F1D1D;
}

.vacant{
    background:#BBF7D0;
    color:#14532D;
}

/* BADGES */

.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-green{
    background:#DCFCE7;
    color:#166534;
}

.badge-red{
    background:#FEE2E2;
    color:#991B1B;
}

/* BUTTON */

.back-btn{
    display:inline-block;
    margin-top:25px;
    background:#145DA0;
    color:white;
    padding:14px 20px;
    border-radius:12px;
    text-decoration:none;
    font-weight:700;
}

.back-btn:hover{
    background:#0D3B66;
}

</style>

<div class="page-wrapper">

    <!-- HEADER -->

    <div class="header-box">

        <h1>

            {{ $ward->ward_name }}

        </h1>

        <p>

            {{ $ward->location }}

        </p>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <div class="stat-card">

            <h3>Total Beds</h3>

            <p>

                {{ $ward->total_beds }}

            </p>

        </div>

        <div class="stat-card">

            <h3>Occupied Beds</h3>

            <p>

                {{ $currentPatients->count() }}

            </p>

        </div>

        <div class="stat-card">

            <h3>Available Beds</h3>

            <p>

                {{ $availableBeds }}

            </p>

        </div>

        <div class="stat-card">

            <h3>Telephone Extension</h3>

            <p>

                {{ $ward->telephone_extension }}

            </p>

        </div>

    </div>

    <!-- MAIN CONTENT -->

    <div class="main-grid">

        <!-- CURRENT PATIENTS -->

        <div class="panel">

            <div class="panel-title">

                Current Patients

            </div>

            @forelse($currentPatients as $allocation)

                <div class="patient-card">

                    <h4>

                        Patient ID:
                        {{ $allocation->patient_id }}

                    </h4>

                    <p>

                        Bed Number:
                        {{ $allocation->bed_number }}

                    </p>

                    <p>

                        Date Placed:
                        {{ $allocation->date_placed }}

                    </p>

                    <span class="badge badge-green">

                        Occupied

                    </span>

                </div>

            @empty

                <p>

                    No active patients found.

                </p>

            @endforelse

        </div>

        <!-- BED MAP -->

        <div class="panel">

            <div class="panel-title">

                Bed Occupancy Map

            </div>

            <div class="bed-grid">

                @foreach($bedMap as $bedNumber => $allocation)

                    <div class="bed {{ $allocation ? 'occupied' : 'vacant' }}">

                        Bed {{ $bedNumber }}

                    </div>

                @endforeach

            </div>

            <div style="margin-top:20px;">

                <span class="badge badge-red">

                    Occupied

                </span>

                <span class="badge badge-green">

                    Vacant

                </span>

            </div>

        </div>

    </div>

    <!-- BACK -->

    <a href="{{ route('wards.index') }}"
       class="back-btn">

        ← Back to Ward Management

    </a>

</div>

@endsection