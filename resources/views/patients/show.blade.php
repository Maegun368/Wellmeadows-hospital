@extends('layouts.app')

@section('title', 'Patient')

@section('topbar-actions')
    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('patients.list') }}" class="btn">Back to list</a>
@endsection

@section('content')

    @if(session('success'))
        <div class="card" style="margin-bottom:1rem; background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="max-width:720px;">
        <h1 style="margin:0 0 0.5rem 0; font-size:1.5rem; color:#1a3a5c;">
            {{ $patient->first_name }} {{ $patient->last_name }}
        </h1>
        <p style="color:#718096; font-size:14px; margin-bottom:1.25rem;">Patient ID {{ $patient->id }}</p>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px 24px; font-size:14px;">
            <div><strong style="color:#4a5568;">Date of birth</strong><br>{{ $patient->date_of_birth?->format('M j, Y') ?? '—' }}</div>
            <div><strong style="color:#4a5568;">Age</strong><br>{{ $patient->age ?? '—' }}</div>
            <div><strong style="color:#4a5568;">Sex</strong><br>{{ $patient->sex ?? '—' }}</div>
            <div><strong style="color:#4a5568;">Phone</strong><br>{{ $patient->phone ?? '—' }}</div>
            <div style="grid-column:1/-1;"><strong style="color:#4a5568;">Address</strong><br>{{ $patient->address ?? '—' }}</div>
            <div><strong style="color:#4a5568;">Ward (record)</strong><br>{{ $patient->ward ?? '—' }}</div>
            <div><strong style="color:#4a5568;">Admission date</strong><br>{{ $patient->admission_date?->format('M j, Y') ?? '—' }}</div>
            <div style="grid-column:1/-1;"><strong style="color:#4a5568;">Doctor</strong><br>{{ $patient->doctor ?? '—' }}</div>
        </div>

        <div style="margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid #e2e8f0;">
            <h2 style="font-size:15px; color:#1a3a5c; margin:0 0 10px 0;">Active bed allocation</h2>
            @forelse($patient->bedAllocations as $allocation)
                <p style="margin:0; font-size:14px;">
                    <strong>{{ $allocation->ward->ward_name ?? 'Ward' }}</strong>,
                    bed {{ $allocation->bed_number }}
                    @if($allocation->date_placed)
                        — since {{ $allocation->date_placed->format('M j, Y') }}
                    @endif
                </p>
            @empty
                <p style="margin:0; color:#718096; font-size:14px;">No active bed assignment. Use <a href="{{ route('bed-allocations.create') }}">bed allocations</a> to assign a ward and bed.</p>
            @endforelse
        </div>

        <div style="margin-top:1.25rem;">
            <h2 style="font-size:15px; color:#1a3a5c; margin:0 0 10px 0;">Next of kin</h2>
            <div style="font-size:14px;">
                {{ $patient->kin_name ?? '—' }}
                @if($patient->kin_relationship)
                    ({{ $patient->kin_relationship }})
                @endif
                @if($patient->kin_phone)
                    — {{ $patient->kin_phone }}
                @endif
            </div>
        </div>
    </div>

@endsection
