@extends('layouts.app')

@section('title', 'Wards & beds')

@section('topbar-actions')
    <a href="{{ route('patients.list') }}" class="btn">Patient list</a>
@endsection

@section('content')

    <div style="max-width:900px;">
        <h1 style="font-size:1.35rem; color:#1a3a5c; margin:0 0 0.35rem 0;">Wards & bed assignment</h1>
        <p style="color:#718096; font-size:14px; margin:0 0 1.5rem 0;">
            Manage wards, view occupancy, and assign patients to beds.
        </p>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:1rem;">

            <a href="{{ route('wards.index') }}" style="text-decoration:none;">
                <div class="card" style="display:flex; flex-direction:column; gap:0.5rem; cursor:pointer; min-height:100px;">
                    <div style="font-weight:600; color:#1a3a5c; font-size:15px;">Ward management</div>
                    <div style="font-size:13px; color:#718096;">View all wards, capacity, and open a ward for details.</div>
                </div>
            </a>

            <a href="{{ route('bed-allocations.index') }}" style="text-decoration:none;">
                <div class="card" style="display:flex; flex-direction:column; gap:0.5rem; cursor:pointer; min-height:100px;">
                    <div style="font-weight:600; color:#1a3a5c; font-size:15px;">Bed allocations</div>
                    <div style="font-size:13px; color:#718096;">List active and past assignments; discharge or edit.</div>
                </div>
            </a>

            <a href="{{ route('bed-allocations.create') }}" style="text-decoration:none;">
                <div class="card" style="display:flex; flex-direction:column; gap:0.5rem; cursor:pointer; min-height:100px; border:1px solid #2e86c1;">
                    <div style="font-weight:600; color:#1a5276; font-size:15px;">+ Assign a bed</div>
                    <div style="font-size:13px; color:#718096;">Admit a patient to a ward and bed number.</div>
                </div>
            </a>

        </div>
    </div>

@endsection
