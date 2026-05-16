@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <div class="card">

        <!-- HIGHLIGHTED HEADER -->
        <div style="
            background: linear-gradient(135deg, #145DA0, #2D7DD2);
            margin: -0px -0px 1.5rem -0px;
            padding: 20px 24px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        ">
            <div>
                <h2 style="
                    margin: 0;
                    color: white;
                    font-size: 22px;
                    font-weight: 700;
                    letter-spacing: 0.5px;
                ">Bed Allocations</h2>
                <p style="
                    margin: 4px 0 0 0;
                    color: #DBEAFE;
                    font-size: 12px;
                ">{{ now()->format('F d, Y | h:i A') }}</p>
            </div>
            <a href="{{ route('bed-allocations.create') }}" style="
                background: white;
                color: #145DA0;
                padding: 10px 18px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 700;
                font-size: 14px;
                border: none;
            ">+ Assign Bed</a>
        </div>

        <!-- SEARCH -->
        <form method="GET" style="display:flex; gap:8px; margin-bottom:1rem;">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Search patient..."
                   style="padding:8px 12px; border-radius:8px; border:1px solid #cbd5e0; font-size:13px; width:250px;">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Ward</th>
                    <th>Bed Number</th>
                    <th>Status</th>
                    <th>Expected Leave</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allocations as $allocation)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($allocation->patient)
                            <span style="font-weight:500;">{{ $allocation->patient->first_name }} {{ $allocation->patient->last_name }}</span>
                            <span style="display:block; font-size:11px; color:#718096;">ID {{ $allocation->patient_id }}</span>
                        @else
                            ID {{ $allocation->patient_id }}
                        @endif
                    </td>
                    <td>{{ $allocation->ward->ward_name ?? 'N/A' }}</td>
                    <td>Bed {{ $allocation->bed_number }}</td>
                    <td>
                        @if($allocation->actual_leave_date)
                            <span class="badge badge-amber">Discharged</span>
                        @else
                            <span class="badge badge-green">Occupied</span>
                        @endif
                    </td>
                    <td>{{ $allocation->date_expected_leave?->format('Y-m-d') ?? 'N/A' }}</td>
                    <td style="white-space:nowrap; display:flex; gap:6px;">
                        <a href="{{ route('bed-allocations.edit', $allocation) }}"
                           class="btn"
                           style="font-size:12px; padding:5px 12px;">Edit</a>
                        @if(!$allocation->actual_leave_date)
                            <form action="{{ route('bed-allocations.discharge', $allocation) }}" method="POST"
                                  onsubmit="return confirm('Discharge this patient?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger"
                                        style="font-size:12px; padding:5px 12px;">Discharge</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#718096; padding:2rem;">
                        No bed allocations found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:1rem;">{{ $allocations->links() }}</div>

    </div>
</div>
@endsection