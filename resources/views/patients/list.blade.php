@extends('layouts.app')

@section('title', 'Patients')

@section('hide-topbar', true)

@section('content')

<style>
:root {
    --blue-dark:  #1a5276;
    --blue-mid:   #2e86c1;
    --blue-light: #5dade2;
    --blue-pale:  #d6eaf8;
    --blue-bg:    #e8f4fd;
    --white:      #ffffff;
}

/* ── Page Header ── */
.pl-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: var(--blue-dark);
    gap: 16px;
}
.pl-header h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
}
.pl-header-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
}
.pl-header-actions { display: flex; gap: 10px; }

.btn-outline-white {
    background: transparent;
    color: var(--white);
    border: 1px solid rgba(255,255,255,0.45);
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background .15s;
}
.btn-outline-white:hover { background: rgba(255,255,255,0.12); }

.btn-solid-white {
    background: var(--white);
    color: var(--blue-dark);
    border: none;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: opacity .15s;
}
.btn-solid-white:hover { opacity: 0.9; }

/* ── Page Body ── */
.pl-body {
    background: var(--blue-bg);
    min-height: calc(100vh - 60px);
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.pl-page-card {
    background: var(--white);
    border: 2px solid var(--blue-pale);
    border-radius: 18px;
    box-shadow: 0 24px 60px rgba(46,134,193,0.08);
    overflow: hidden;
}

.pl-page-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 24px 28px;
    border-bottom: 1px solid var(--blue-pale);
    background: #fcfdff;
}

.pl-page-card-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--blue-dark);
    margin: 0;
}

.pl-page-card-sub {
    margin-top: 4px;
    color: #4a5568;
    font-size: 13px;
}

.pl-page-card-body {
    padding: 24px 28px 28px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* ── Quick Link Cards ── */
.pl-quicklinks {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}
.ql-card {
    background: var(--white);
    border: 2px solid var(--blue-pale);
    border-radius: 14px;
    padding: 18px 22px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
    transition: border-color .15s, box-shadow .15s;
    cursor: pointer;
}
.ql-card:hover {
    border-color: var(--blue-mid);
    box-shadow: 0 16px 32px rgba(46,134,193,0.08);
}
.ql-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--blue-dark);
}
.ql-sub {
    font-size: 12px;
    color: #4a5568;
}

/* ── Success Alert ── */
.alert-success {
    background: #d1fae5;
    border: 1px solid #6ee7b7;
    color: #065f46;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
}

/* ── Table Card ── */
.table-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
}
.table-card-header {
    background: var(--blue-mid);
    padding: 12px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.table-card-header span {
    font-size: 12px;
    font-weight: 700;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.table-card-body { padding: 16px 18px; }

/* ── Search ── */
.search-wrap { margin-bottom: 14px; }
.search-input {
    width: 100%;
    padding: 9px 14px;
    border-radius: 8px;
    border: 1px solid var(--blue-light);
    font-size: 13px;
    color: #2d3748;
    background: #f0f8ff;
    font-family: inherit;
    transition: border-color .15s, box-shadow .15s;
    box-sizing: border-box;
}
.search-input:focus {
    outline: none;
    border-color: var(--blue-dark);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(41,128,185,0.15);
}

/* ── Patient Table ── */
.pt-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.pt-table thead tr {
    background: var(--blue-pale);
}
.pt-table th {
    padding: 10px 12px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: var(--blue-dark);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 2px solid var(--blue-light);
}
.pt-table td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--blue-pale);
    color: #2d3748;
    vertical-align: middle;
}
.pt-table tbody tr:hover { background: #f0f8ff; }
.pt-table tbody tr:last-child td { border-bottom: none; }

.pt-id {
    font-weight: 700;
    color: var(--blue-mid);
    font-size: 12px;
}
.pt-name { font-weight: 600; color: var(--blue-dark); }
.empty-row td {
    text-align: center;
    color: var(--blue-light);
    padding: 2.5rem;
    font-style: italic;
    font-size: 13px;
}

/* ── Action Buttons ── */
.action-wrap { display: flex; gap: 6px; align-items: center; }

.btn-view {
    background: var(--white);
    color: var(--blue-dark);
    border: 1px solid var(--blue-light);
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background .15s;
    display: inline-flex; align-items: center;
}
.btn-view:hover { background: var(--blue-pale); }

.btn-edit {
    background: var(--white);
    color: var(--blue-mid);
    border: 1px solid var(--blue-mid);
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background .15s;
    display: inline-flex; align-items: center;
}
.btn-edit:hover { background: var(--blue-pale); }

.btn-delete {
    background: var(--white);
    color: #e74c3c;
    border: 1px solid #e74c3c;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    display: inline-flex; align-items: center; gap: 4px;
    font-family: inherit;
}
.btn-delete:hover { background: #fadbd8; }

/* ── Pagination ── */
.pagination-wrap {
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid var(--blue-pale);
}
</style>

{{-- Page Header --}}
<div class="pl-body">

    <div class="pl-page-card">
        <div class="pl-page-card-header">
            <div>
                <h2 class="pl-page-card-title">Patients</h2>
                <div class="pl-page-card-sub">Patient records &amp; management</div>
            </div>
            <div class="pl-header-actions">
                <a href="{{ route('patients.index') }}" class="btn-outline-white">Dashboard</a>
                <a href="{{ route('patients.create') }}" class="btn-solid-white">+ New Patient</a>
            </div>
        </div>

        <div class="pl-page-card-body">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            {{-- Quick Links --}}
            <div class="pl-quicklinks">
        <a href="{{ route('patients.index') }}" class="ql-card">
            <div class="ql-title">Patient Dashboard</div>
            <div class="ql-sub">Stats &amp; overview</div>
        </a>
        <a href="{{ route('patients.wards-bed') }}" class="ql-card">
            <div class="ql-title">Wards &amp; Bed Assignment</div>
            <div class="ql-sub">Assign patients to wards</div>
        </a>
        <a href="/billing" class="ql-card">
            <div class="ql-title">Billing Details</div>
            <div class="ql-sub">View billing information</div>
        </a>
    </div>

    {{-- Patient Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <span>All Patients</span>
            <span style="background:rgba(255,255,255,0.2); padding:3px 10px; border-radius:4px; font-size:11px;">
                {{ $patients->total() }} records
            </span>
        </div>
        <div class="table-card-body">

            {{-- Search --}}
            <div class="search-wrap">
                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Search patient..."
                    onkeyup="filterTable()"
                >
            </div>

            {{-- Table --}}
            <table class="pt-table" id="patientTable">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Patient Phone</th>
                        <th>Guardian Name</th>
                        <th>Guardian Phone</th>
                        <th>Ward</th>
                        <th>Admission Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td class="pt-id">{{ $patient->id }}</td>
                        <td class="pt-name">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                        <td>{{ $patient->age ?? '—' }}</td>
                        <td>{{ $patient->sex ?? '—' }}</td>
                        <td>{{ $patient->phone ?? '—' }}</td>
                        <td>{{ $patient->nextOfKins->first()->name ?? '—' }}</td>
                        <td>{{ $patient->nextOfKins->first()->phone ?? '—' }}</td>
                        <td>{{ $patient->ward ?? '—' }}</td>
                        <td>{{ $patient->admission_date ? \Carbon\Carbon::parse($patient->admission_date)->format('M j, Y') : '—' }}</td>
                        <td>
                            <div class="action-wrap">
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn-view">View</a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this patient?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">🗑 Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="8">No patients found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="pagination-wrap">
                {{ $patients->links() }}
            </div>

        </div>
    </div>
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