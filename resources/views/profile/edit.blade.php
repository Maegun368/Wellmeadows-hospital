@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-pale:   #d6eaf8;
    --blue-bg:     #e8f4fd;
    --white:       #ffffff;
}

.profile-wrapper {
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 2rem;
    background: var(--blue-bg);
}

.profile-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    width: 100%;
    max-width: 700px;
    overflow: hidden;
}

.profile-card-header {
    background: var(--blue-dark);
    padding: 16px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0;
}

.card-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    margin-top: 2px;
}

.profile-card-body {
    padding: 24px;
}

.section-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--blue-mid);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 12px;
    margin-top: 16px;
    padding-bottom: 6px;
    border-bottom: 1px solid var(--blue-pale);
}

.section-label:first-child {
    margin-top: 0;
}

.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid var(--blue-light);
    font-size: 13px;
    color: #2d3748;
    background: #f0f8ff;
    font-family: inherit;
    transition: border-color .15s, box-shadow .15s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--blue-dark);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(41,128,185,0.15);
}

.field-error {
    color: #e74c3c;
    font-size: 11px;
    margin-top: 4px;
    display: block;
}

.form-actions {
    display: flex;
    gap: 10px;
    padding-top: 16px;
    border-top: 1px solid var(--blue-pale);
    margin-top: 8px;
}

.btn-save {
    background: var(--blue-dark);
    color: var(--white);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    transition: background .15s;
}

.btn-save:hover {
    background: var(--blue-mid);
}

.btn-cancel {
    background: var(--white);
    color: #4a5568;
    border: 1px solid #cbd5e0;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    transition: background .15s;
    display: inline-flex;
    align-items: center;
}

.btn-cancel:hover {
    background: #edf2f7;
}

.btn-danger {
    background: #e74c3c;
    color: var(--white);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    transition: background .15s;
    display: inline-flex;
    align-items: center;
}

.btn-danger:hover {
    background: #c0392b;
}

.divider {
    height: 1px;
    background: var(--blue-pale);
    margin: 24px 0;
}
</style>

<div class="profile-wrapper">
    <div class="profile-card">

        <div class="profile-card-header">
            <div>
                <div class="card-title">Edit Profile</div>
                <div class="card-sub">{{ Auth::user()->name }}</div>
            </div>
        </div>

        <div class="profile-card-body">

            <!-- Update Profile Information -->
            <div class="section-label">Profile Information</div>
            @include('profile.partials.update-profile-information-form')

            <div class="divider"></div>

            <!-- Update Password -->
            <div class="section-label">Update Password</div>
            @include('profile.partials.update-password-form')

            <div class="divider"></div>

            <!-- Delete Account -->
            <div class="section-label" style="color: #e74c3c;">Danger Zone</div>
            @include('profile.partials.delete-user-form')

        </div>

    </div>

    <!-- Back Button -->
    <div style="text-align: center; margin-top: 24px; width: 100%; max-width: 700px;">
        <a href="{{ route('profile.show') }}" class="btn-cancel">
            Back to Profile
        </a>
    </div>

</div>

@endsection
