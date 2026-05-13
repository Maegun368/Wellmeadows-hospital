@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <div class="card" style="max-width:640px; margin:0 auto;">

        <!-- HEADER -->
        <div style="
            background: linear-gradient(135deg, #145DA0, #2D7DD2);
            padding: 20px 24px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        ">
            <div>
                <h2 style="margin:0; color:white; font-size:20px; font-weight:700;">✏️ Edit Bed Allocation</h2>
                <p style="margin:4px 0 0 0; color:#DBEAFE; font-size:12px;">
                    Patient:
                    <strong>
                        @if($bedAllocation->patient)
                            {{ $bedAllocation->patient->first_name }} {{ $bedAllocation->patient->last_name }}
                            (ID {{ $bedAllocation->patient_id }})
                        @else
                            ID {{ $bedAllocation->patient_id }}
                        @endif
                    </strong>
                </p>
            </div>
            <a href="{{ route('bed-allocations.index') }}" style="
                background: white;
                color: #145DA0;
                padding: 8px 16px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 700;
                font-size: 13px;
            ">← Back</a>
        </div>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left:1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bed-allocations.update', $bedAllocation) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Ward</label>
                <select name="ward_id" required>
                    @foreach($wards as $ward)
                        <option value="{{ $ward->ward_id }}" @selected(old('ward_id', $bedAllocation->ward_id) == $ward->ward_id)>
                            {{ $ward->ward_name }} — {{ $ward->location }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Bed Number</label>
                <input type="number" name="bed_number" min="1"
                       value="{{ old('bed_number', $bedAllocation->bed_number) }}" required>
            </div>

            <div class="form-group">
                <label>Date Placed Waiting (optional)</label>
                <input type="date" name="date_placed_waiting"
                       value="{{ old('date_placed_waiting', optional($bedAllocation->date_placed_waiting)->format('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label>Expected Duration (days) (optional)</label>
                <input type="number" name="expected_duration_days" min="1"
                       value="{{ old('expected_duration_days', $bedAllocation->expected_duration_days) }}">
            </div>

            <div class="form-group">
                <label>Expected Leave Date (optional)</label>
                <input type="date" name="date_expected_leave"
                       value="{{ old('date_expected_leave', optional($bedAllocation->date_expected_leave)->format('Y-m-d')) }}">
            </div>

            <div style="display:flex; gap:10px; margin-top:1rem;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('bed-allocations.index') }}" class="btn">Cancel</a>
            </div>

        </form>

        @if(!$bedAllocation->actual_leave_date)
            <form method="POST" action="{{ route('bed-allocations.discharge', $bedAllocation) }}"
                  style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid #E5E7EB;"
                  onsubmit="return confirm('Discharge this patient from this bed?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger">Discharge Patient</button>
            </form>
        @endif

        @if($bedAllocation->actual_leave_date)
            <form method="POST" action="{{ route('bed-allocations.destroy', $bedAllocation) }}"
                  style="margin-top:1rem;"
                  onsubmit="return confirm('Delete this allocation record?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:none; border:none; color:#DC2626; font-size:13px; font-weight:600; cursor:pointer; text-decoration:underline;">
                    Delete record
                </button>
            </form>
        @endif

    </div>
</div>
@endsection