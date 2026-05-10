@extends('layouts.app')

@section('title', 'Patients')

@section('topbar-actions')
    <a href="{{ route('patients.create') }}" class="btn btn-primary">+ New Patient</a>
@endsection

@section('content')

    {{-- Quick Links --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">

        <a href="{{ route('patients.index') }}" style="text-decoration:none;">
            <div class="card" style="display:flex; align-items:center; gap:1rem; cursor:pointer;">
                
                <div>
                    <div style="font-weight:600; color:#1a3a5c; font-size:14px;">Patient Medical Records</div>
                    <div style="font-size:12px; color:#718096;">View & manage records</div>
                </div>
            </div>
        </a>

        <a href="/wards-bed" style="text-decoration:none;">
            <div class="card" style="display:flex; align-items:center; gap:1rem; cursor:pointer;">
                <div>
                    <div style="font-weight:600; color:#1a3a5c; font-size:14px;">Wards & Bed Assignment</div>
                    <div style="font-size:12px; color:#718096;">Assign patients to wards</div>
                </div>
            </div>
        </a>

        <a href="/billing" style="text-decoration:none;">
            <div class="card" style="display:flex; align-items:center; gap:1rem; cursor:pointer;">
                <div>
                    <div style="font-weight:600; color:#1a3a5c; font-size:14px;">Billing Details</div>
                    <div style="font-size:12px; color:#718096;">View billing information</div>
                </div>
            </div>
        </a>

    </div>

    {{-- Patient Table --}}
    <div class="card">

        {{-- Search --}}
        <div style="display:flex; gap:1rem; margin-bottom:1rem;">
            <input
                type="text"
                id="searchInput"
                placeholder="Search patient..."
                onkeyup="filterTable()"
                style="flex:1; padding:8px 12px; border-radius:8px; border:1px solid #cbd5e0; font-size:13px;"
            >
        </div>

        {{-- Table --}}
        <table id="patientTable">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Ward</th>
                    <th>Admission Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->age }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->contact_number }}</td>
                    <td>{{ $patient->ward ?? '—' }}</td>
                    <td>{{ $patient->admission_date ?? '—' }}</td>
                    <td style="display:flex; gap:6px;">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn">View</a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn">Edit</a>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                              onsubmit="return confirm('Delete this patient?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#718096; padding:2rem;">
                        No patients found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="margin-top:1rem;">
            {{ $patients->links() }}
        </div>

    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#patientTable tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
            });
        }
    </script>

@endsection