@extends('layouts.app')

@section('title', 'Staff Details')

@section('topbar-actions')
    <div style="display:flex; gap:8px;">
        <a href="{{ route('staff.edit', $staff->staff_id) }}" class="btn">✏️ Edit</a>
        <form action="{{ route('staff.destroy', $staff->staff_id) }}" method="POST"
              onsubmit="return confirm('Delete this staff member?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑 Delete</button>
        </form>
        <a href="{{ route('staff.index') }}" class="btn">← Back</a>
    </div>
@endsection

@section('content')

    <div class="card" style="margin-bottom:1rem;">
        <div style="display:flex; align-items:center; gap:1.5rem;">
            <div style="width:64px; height:64px; border-radius:50%; background:#1a3a5c;
                        display:flex; align-items:center; justify-content:center;
                        font-size:24px; color:#fff;">👤</div>
            <div>
                <div style="font-size:18px; font-weight:700; color:#1a3a5c;">
                    {{ $staff->first_name }} {{ $staff->last_name }}
                </div>
                <div style="font-size:13px; color:#718096;">{{ $staff->position }}</div>
                <div style="margin-top:4px;">
                    @if($staff->contract_type === 'Full-time')
                        <span class="badge badge-green">Full-time</span>
                    @else
                        <span class="badge badge-amber">Part-time</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
        <div class="card">
            <div class="card-title">Personal Information</div>
            <table>
                <tr><td style="color:#718096; width:45%;">Staff ID</td><td>{{ $staff->staff_id }}</td></tr>
                <tr><td style="color:#718096;">Date of Birth</td><td>{{ $staff->date_of_birth }}</td></tr>
                <tr><td style="color:#718096;">Sex</td><td>{{ $staff->sex }}</td></tr>
                <tr><td style="color:#718096;">NIN</td><td>{{ $staff->NIN }}</td></tr>
                <tr><td style="color:#718096;">Phone</td><td>{{ $staff->phone }}</td></tr>
                <tr><td style="color:#718096;">Address</td><td>{{ $staff->address }}</td></tr>
            </table>
        </div>
        <div class="card">
            <div class="card-title">Employment Details</div>
            <table>
                <tr><td style="color:#718096; width:45%;">Position</td><td>{{ $staff->position }}</td></tr>
                <tr><td style="color:#718096;">Contract Type</td><td>{{ $staff->contract_type }}</td></tr>
                <tr><td style="color:#718096;">Pay Type</td><td>{{ $staff->pay_type }}</td></tr>
                <tr><td style="color:#718096;">Hours/Week</td><td>{{ $staff->hours_per_week }} hrs</td></tr>
                <tr><td style="color:#718096;">Current Salary</td><td>£{{ number_format($staff->current_salary, 2) }}</td></tr>
                <tr><td style="color:#718096;">Salary Scale</td><td>{{ $staff->salary_scale }}</td></tr>
            </table>
        </div>
    </div>

    <div class="card" style="margin-bottom:1rem;">
        <div class="card-title">🎓 Qualifications</div>
        @if($staff->qualifications->count())
        <table>
            <thead>
                <tr><th>Qualification</th><th>Institution</th><th>Year</th></tr>
            </thead>
            <tbody>
                @foreach($staff->qualifications as $q)
                <tr>
                    <td>{{ $q->qualification_type ?? '—' }}</td>
                    <td>{{ $q->institution ?? '—' }}</td>
                    <td>{{ $q->year ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p style="color:#718096; font-size:13px;">No qualifications recorded.</p>
        @endif
    </div>

    <div class="card">
        <div class="card-title">💼 Work Experience</div>
        @if($staff->workExperiences->count())
        <table>
            <thead>
                <tr><th>Organization</th><th>Position</th><th>Start Date</th><th>End Date</th></tr>
            </thead>
            <tbody>
                @foreach($staff->workExperiences as $w)
                <tr>
                    <td>{{ $w->organization ?? '—' }}</td>
                    <td>{{ $w->position ?? '—' }}</td>
                    <td>{{ $w->start_date ?? '—' }}</td>
                    <td>{{ $w->end_date ?? 'Present' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p style="color:#718096; font-size:13px;">No work experience recorded.</p>
        @endif
    </div>

@endsection