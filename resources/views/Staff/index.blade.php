@extends('layouts.app')

@section('title', 'Staff')

@section('topbar-actions')
    <a href="{{ route('staff.create') }}" class="btn btn-primary">+ New Staff</a>
@endsection

@section('content')

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
        <a href="#" style="text-decoration:none;">
            <div class="card" style="display:flex; align-items:center; gap:1rem; cursor:pointer;">
                <span style="font-size:2rem;">🎓</span>
                <div>
                    <div style="font-weight:600; color:#1a3a5c; font-size:14px;">Qualifications</div>
                    <div style="font-size:12px; color:#718096;">View & manage staff qualifications</div>
                </div>
            </div>
        </a>
        <a href="#" style="text-decoration:none;">
            <div class="card" style="display:flex; align-items:center; gap:1rem; cursor:pointer;">
                <span style="font-size:2rem;">💼</span>
                <div>
                    <div style="font-weight:600; color:#1a3a5c; font-size:14px;">Work Experience</div>
                    <div style="font-size:12px; color:#718096;">View & manage work history</div>
                </div>
            </div>
        </a>
    </div>

    <div class="card">
        <div style="display:flex; gap:1rem; margin-bottom:1rem;">
            <input type="text" id="searchInput" placeholder="Search staff..."
                onkeyup="filterTable()"
                style="flex:1; padding:8px 12px; border-radius:8px; border:1px solid #cbd5e0; font-size:13px;">
            <select id="contractFilter" onchange="filterTable()"
                style="padding:8px 12px; border-radius:8px; border:1px solid #cbd5e0; font-size:13px;">
                <option value="">All contracts</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
            </select>
        </div>

        <table id="staffTable">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Contract</th>
                    <th>Hours/Week</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr data-contract="{{ $member->contract_type }}">
                    <td>{{ $member->staff_id }}</td>
                    <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                    <td>{{ $member->position }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>
                        @if($member->contract_type === 'Full-time')
                            <span class="badge badge-green">Full-time</span>
                        @else
                            <span class="badge badge-amber">Part-time</span>
                        @endif
                    </td>
                    <td>{{ $member->hours_per_week }} hrs</td>
                    <td>£{{ number_format($member->current_salary, 2) }}</td>
                    <td style="display:flex; gap:6px;">
                        <a href="{{ route('staff.show', $member->staff_id) }}" class="btn">👁 View</a>
                        <a href="{{ route('staff.edit', $member->staff_id) }}" class="btn">✏️ Edit</a>
                        <form action="{{ route('staff.destroy', $member->staff_id) }}" method="POST"
                              onsubmit="return confirm('Delete this staff member?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#718096; padding:2rem;">
                        No staff found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:1rem;">{{ $staff->links() }}</div>
    </div>

    <script>
        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const contract = document.getElementById('contractFilter').value;
            const rows = document.querySelectorAll('#staffTable tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const rowContract = row.dataset.contract || '';
                const matchSearch = text.includes(search);
                const matchContract = contract === '' || rowContract === contract;
                row.style.display = matchSearch && matchContract ? '' : 'none';
            });
        }
    </script>

@endsection