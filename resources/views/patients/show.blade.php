@extends('layouts.app')
@section('title', 'Patient Details')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-accent: #2980b9;
    --blue-pale:   #d6eaf8;
    --white:       #ffffff;
}

.create-wrapper {
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 2rem;
    background: #e8f4fd;
}

.create-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    width: 100%;
    max-width: 750px;
    overflow: hidden;
}

.create-card-header {
    background: var(--blue-dark);
    padding: 16px 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.create-card-header .card-icon {
    background: rgba(255,255,255,0.15);
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.create-card-header .card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.create-card-header .card-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
}

.create-card-body {
    padding: 24px;
}

.section-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--blue-mid);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 16px;
    margin-top: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--blue-pale);
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-item {
    font-family: 'DM Sans', sans-serif;
}

.info-item label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.info-item span {
    font-size: 14px;
    color: #2d3748;
}

.full-width {
    grid-column: 1 / -1;
}

.btn-group {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid var(--blue-pale);
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.btn-primary {
    background: var(--blue-mid);
    color: white;
    border: none;
}

.btn-primary:hover {
    background: var(--blue-dark);
}

.btn-secondary {
    background: #f0f8ff;
    color: var(--blue-dark);
    border: 1px solid var(--blue-light);
}

.btn-secondary:hover {
    background: var(--blue-pale);
}

.success-alert {
    background: #d1fae5;
    border: 1px solid #6ee7b7;
    color: #065f46;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 14px;
}
</style>

<div class="create-wrapper">
    <div class="create-card">
        <div class="create-card-header">
            <div class="card-icon">👤</div>
            <div>
                <h2 class="card-title">{{ $patient->first_name }} {{ $patient->last_name }}</h2>
                <div class="card-sub">Patient ID: {{ $patient->id }} | Wellmeadows Hospital</div>
            </div>
        </div>
        
        <div class="create-card-body">
            @if(session('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="section-label">Personal Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Date of Birth</label>
                    <span>{{ $patient->date_of_birth?->format('M j, Y') ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Age</label>
                    <span>{{ $patient->age ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Sex</label>
                    <span>{{ $patient->sex ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Phone</label>
                    <span>{{ $patient->phone ?? '—' }}</span>
                </div>
                <div class="info-item full-width">
                    <label>Address</label>
                    <span>{{ $patient->address ?? '—' }}</span>
                </div>
            </div>

            <div class="section-label">Medical Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Ward</label>
                    <span>{{ $patient->ward ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Admission Date</label>
                    <span>{{ $patient->admission_date?->format('M j, Y') ?? '—' }}</span>
                </div>
                <div class="info-item full-width">
                    <label>Assigned Doctor</label>
                    <span>{{ $patient->doctor ?? '—' }}</span>
                </div>
            </div>

            <div class="section-label">Active Bed Allocation</div>
            <div class="info-grid">
                @forelse($patient->bedAllocations as $allocation)
                    <div class="info-item">
                        <label>Ward</label>
                        <span>{{ $allocation->ward->ward_name ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Bed Number</label>
                        <span>{{ $allocation->bed_number ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Placed Since</label>
                        <span>{{ $allocation->date_placed?->format('M j, Y') ?? '—' }}</span>
                    </div>
                @empty
                    <div class="info-item full-width">
                        <span style="color:#718096;">No active bed assignment. Use <a href="{{ route('bed-allocations.create') }}">bed allocations</a> to assign a ward and bed.</span>
                    </div>
                @endforelse
            </div>

            <div class="section-label">Next of Kin</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Guardian Name</label>
                    <span>{{ $patient->kin_name ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Relationship</label>
                    <span>{{ $patient->kin_relationship ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <label>Guardian Phone</label>
                    <span>{{ $patient->kin_phone ?? '—' }}</span>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-primary">Edit Patient</a>
                <a href="{{ route('patients.list') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

@endsection