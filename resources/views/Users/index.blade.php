@extends('layouts.app')
@section('title', 'User Management')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-accent: #2980b9;
    --blue-pale:   #d6eaf8;
    --blue-bg:     #e8f4fd;
    --white:       #ffffff;
}

.um-topbar {
    background: var(--blue-dark);
    padding: 14px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.um-topbar h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.um-topbar-sub { font-size: 11px; color: rgba(255,255,255,0.55); margin-top: 2px; }
.um-topbar-right { display: flex; gap: 10px; align-items: center; }

.btn-add {
    background: var(--white);
    color: var(--blue-dark);
    border: none;
    padding: 9px 18px;
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
.btn-add:hover { opacity: 0.9; }

.um-body {
    padding: 24px;
    background: var(--blue-bg);
    min-height: calc(100vh - 60px);
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 16px;
}
.alert-success { background: #a9dfbf; color: #1e8449; }
.alert-error   { background: #fadbd8; color: #c0392b; }

.panel {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    overflow: hidden;
}
.panel-header {
    background: var(--blue-mid);
    padding: 10px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.panel-title {
    font-size: 12px;
    font-weight: 700;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.um-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.um-table th {
    text-align: left;
    padding: 9px 14px;
    background: #f0f8ff;
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid var(--blue-pale);
}
.um-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #f0f8ff;
    color: #2d3748;
    vertical-align: middle;
}
.um-table tr:last-child td { border-bottom: none; }
.um-table tr:hover td { background: #f0f8ff; }

.user-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: var(--blue-mid);
    color: var(--white);
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.user-name-cell { display: flex; align-items: center; gap: 8px; }
.user-name  { font-weight: 600; color: var(--blue-dark); }
.user-email { font-size: 11px; color: #718096; }

.role-badge {
    display: inline-block;
    font-size: 10px;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 600;
}
.role-medical_director  { background: #fdebd0; color: #935116; }
.role-personnel_officer { background: var(--blue-pale); color: var(--blue-dark); }
.role-charge_nurse      { background: #d5f5e3; color: #1e8449; }
.role-none              { background: #f2f3f4; color: #566573; }

.tbl-btn {
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid var(--blue-mid);
    background: var(--white);
    color: var(--blue-dark);
    cursor: pointer;
    text-decoration: none;
    font-weight: 500;
    transition: background .15s;
    display: inline-block;
}
.tbl-btn:hover { background: var(--blue-pale); }
.tbl-btn-danger { border-color: #e74c3c; color: #c0392b; }
.tbl-btn-danger:hover { background: #fadbd8; }

.panel-pagination {
    padding: 10px 14px;
    border-top: 1px solid var(--blue-pale);
    display: flex;
    justify-content: flex-end;
    background: #f9fcff;
}

.you-badge {
    font-size: 10px;
    background: var(--blue-pale);
    color: var(--blue-mid);
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 4px;
    font-weight: 600;
}
</style>

{{-- Top bar --}}
<div class="um-topbar">
    <div>
        <h2>User Management</h2>
        <div class="um-topbar-sub">{{ now()->format('F d, Y | h:i A') }}</div>
    </div>
    <div class="um-topbar-right">
        <a href="{{ route('users.create') }}" class="btn-add">+ Add User</a>
    </div>
</div>

{{-- Body --}}
<div class="um-body">

    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">✕ {{ session('error') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">All Users</span>
            <span style="font-size:11px;color:rgba(255,255,255,0.7);">{{ $users->total() }} total</span>
        </div>

        <table class="um-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $initials = strtoupper(substr($user->name, 0, 1));
                    $role = $user->roles->first()?->name ?? 'none';
                    $roleLabel = match($role) {
                        'medical_director'  => 'Medical Director',
                        'personnel_officer' => 'Personnel Officer',
                        'charge_nurse'      => 'Charge Nurse',
                        default             => 'No Role',
                    };
                @endphp
                <tr>
                    <td>
                        <div class="user-name-cell">
                            <div class="user-avatar">{{ $initials }}</div>
                            <div>
                                <div class="user-name">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="you-badge">You</span>
                                    @endif
                                </div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge role-{{ $role }}">{{ $roleLabel }}</span>
                    </td>
                    <td style="font-size:12px; color:#718096;">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td style="display:flex; gap:6px;">
                        <a href="{{ route('users.edit', $user->id) }}" class="tbl-btn">Edit</a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                  style="margin:0" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="tbl-btn tbl-btn-danger">✕</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#5dade2; padding:2rem; font-size:13px;">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="panel-pagination">
            {{ $users->links() }}
        </div>
    </div>

</div>

@endsection