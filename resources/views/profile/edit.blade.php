@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<style>
.ep-wrapper {
    max-width: 520px;
    margin: 2.5rem auto;
    padding: 0 1.5rem 3rem;
}

/* ── Page header ── */
.ep-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}
.ep-header h1 {
    font-size: 22px;
    font-weight: 700;
    color: #1E293B;
    margin: 0;
}
.ep-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #DBEAFE;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    color: #1a3451;
    border: 3px solid #E2E8F0;
}

/* ── Form fields ── */
.ep-field {
    margin-bottom: 16px;
}
.ep-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #1E293B;
    margin-bottom: 6px;
}
.ep-field input,
.ep-field select {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #CBD5E0;
    border-radius: 6px;
    font-size: 13px;
    color: #1E293B;
    background: white;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
}
.ep-field input:focus,
.ep-field select:focus {
    border-color: #F97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
}
.ep-field .ep-error {
    font-size: 11px;
    color: #DC2626;
    margin-top: 4px;
}

/* ── Input with checkmark ── */
.ep-input-wrap {
    position: relative;
}
.ep-input-wrap input {
    padding-right: 36px;
}
.ep-check {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    background: #22C55E;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

/* ── Two column row ── */
.ep-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

/* ── Select arrow ── */
.ep-select-wrap {
    position: relative;
}
.ep-select-wrap::after {
    content: '▾';
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #64748B;
    pointer-events: none;
}
.ep-select-wrap select {
    padding-right: 32px;
}

/* ── Action buttons ── */
.ep-actions {
    display: flex;
    gap: 12px;
    margin-top: 28px;
}
.ep-btn-cancel {
    padding: 10px 28px;
    background: white;
    color: #F97316;
    border: 1.5px solid #F97316;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}
.ep-btn-cancel:hover { background: #FFF7ED; }
.ep-btn-save {
    padding: 10px 28px;
    background: #F97316;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}
.ep-btn-save:hover { background: #EA6A0A; }

/* ── Success message ── */
.ep-success {
    background: #DCFCE7;
    color: #166534;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 16px;
}

/* ── Password section ── */
.ep-divider {
    border: none;
    border-top: 1.5px solid #E2E8F0;
    margin: 24px 0;
}
.ep-section-label {
    font-size: 13px;
    font-weight: 700;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 14px;
}

/* ── Delete link ── */
.ep-delete-link {
    display: block;
    margin-top: 24px;
    font-size: 13px;
    color: #DC2626;
    font-weight: 600;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    text-decoration: underline;
}

/* ── Modal ── */
.ep-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 999;
    align-items: center;
    justify-content: center;
}
.ep-modal-overlay.open { display: flex; }
.ep-modal {
    background: white;
    border-radius: 12px;
    padding: 28px;
    max-width: 420px;
    width: 90%;
}
.ep-modal h3 {
    font-size: 16px;
    font-weight: 700;
    color: #1E293B;
    margin-bottom: 8px;
}
.ep-modal p {
    font-size: 13px;
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 16px;
}
.ep-modal input {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #CBD5E0;
    border-radius: 6px;
    font-size: 13px;
    outline: none;
    margin-bottom: 16px;
}
.ep-modal input:focus { border-color: #EF4444; }
.ep-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.ep-modal-cancel {
    padding: 9px 18px;
    background: #F1F5F9;
    border: 1px solid #CBD5E0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    color: #1E293B;
}
.ep-modal-delete {
    padding: 9px 18px;
    background: #DC2626;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}
</style>

<div class="ep-wrapper">

    {{-- HEADER --}}
    <div class="ep-header">
        <h1>Edit profile</h1>
        <div class="ep-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="ep-success">✓ Profile updated successfully.</div>
    @endif

    @if(session('status') === 'password-updated')
        <div class="ep-success">✓ Password updated successfully.</div>
    @endif

    {{-- PROFILE FORM --}}
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- Name row --}}
        <div class="ep-row">
            <div class="ep-field">
                <label>First Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       required autofocus autocomplete="name">
                @foreach($errors->get('name') as $error)
                    <div class="ep-error">{{ $error }}</div>
                @endforeach
            </div>
            <div class="ep-field">
                <label>Last Name</label>
                <input type="text" name="last_name"
                       value="{{ old('last_name', $user->last_name ?? '') }}"
                       autocomplete="family-name">
            </div>
        </div>

        {{-- Email --}}
        <div class="ep-field">
            <label>Email</label>
            <div class="ep-input-wrap">
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       required autocomplete="username">
                @if($user->hasVerifiedEmail())
                    <span class="ep-check">✓</span>
                @endif
            </div>
            @foreach($errors->get('email') as $error)
                <div class="ep-error">{{ $error }}</div>
            @endforeach
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top:6px; font-size:12px; color:#92400E;">
                    Your email is unverified.
                    <form id="send-verification" method="post"
                          action="{{ route('verification.send') }}" style="display:inline;">
                        @csrf
                        <button type="submit"
                                style="background:none; border:none; color:#F97316; font-weight:600; cursor:pointer; text-decoration:underline; font-size:12px;">
                            Resend verification email
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Contact Number --}}
        <div class="ep-field">
            <label>Contact Number</label>
            <input type="text" name="contact_number"
                   value="{{ old('contact_number', $user->contact_number ?? '') }}"
                   autocomplete="tel">
        </div>

        {{-- Actions --}}
        <div class="ep-actions">
            <a href="{{ url()->previous() }}" class="ep-btn-cancel">Cancel</a>
            <button type="submit" class="ep-btn-save">Save</button>
        </div>

    </form>

    <hr class="ep-divider">

    {{-- PASSWORD FORM --}}
    <div class="ep-section-label">Update Password</div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="ep-field">
            <label>Current Password</label>
            <div class="ep-input-wrap">
                <input type="password" name="current_password" autocomplete="current-password">
                @if(session('status') === 'password-updated')
                    <span class="ep-check">✓</span>
                @endif
            </div>
            @foreach($errors->updatePassword->get('current_password') as $error)
                <div class="ep-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="ep-field">
            <label>New Password</label>
            <input type="password" name="password" autocomplete="new-password">
            @foreach($errors->updatePassword->get('password') as $error)
                <div class="ep-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="ep-field">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" autocomplete="new-password">
            @foreach($errors->updatePassword->get('password_confirmation') as $error)
                <div class="ep-error">{{ $error }}</div>
            @endforeach
        </div>

        <div class="ep-actions">
            <button type="submit" class="ep-btn-save">Update Password</button>
        </div>

    </form>

    <hr class="ep-divider">

    {{-- DELETE ACCOUNT --}}
    <button class="ep-delete-link"
            onclick="document.getElementById('deleteModal').classList.add('open')">
        Delete my account
    </button>

</div>

{{-- DELETE MODAL --}}
<div class="ep-modal-overlay" id="deleteModal">
    <div class="ep-modal">
        <h3>Delete your account?</h3>
        <p>Once deleted, all your data will be permanently removed.
           Please enter your password to confirm.</p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <input type="password" name="password" placeholder="Enter your password" required>
            @foreach($errors->userDeletion->get('password') as $error)
                <div style="font-size:12px; color:#DC2626; margin-top:-10px; margin-bottom:12px;">{{ $error }}</div>
            @endforeach
            <div class="ep-modal-actions">
                <button type="button" class="ep-modal-cancel"
                        onclick="document.getElementById('deleteModal').classList.remove('open')">
                    Cancel
                </button>
                <button type="submit" class="ep-modal-delete">Delete Account</button>
            </div>
        </form>
    </div>
</div>

<script>
@if($errors->userDeletion->isNotEmpty())
    document.getElementById('deleteModal').classList.add('open');
@endif
</script>

@endsection