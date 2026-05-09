@extends('layouts.app')
@section('title', 'New Appointment')

@section('content')

<style>
:root {
    --blue-dark:   #1a5276;
    --blue-mid:    #2e86c1;
    --blue-light:  #5dade2;
    --blue-accent: #2980b9;
    --blue-pale:   #d6eaf8;
    --white:       #ffffff;
}

.create-wrapper {
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: #e8f4fd;
}

.create-card {
    background: var(--white);
    border: 2px solid var(--blue-mid);
    border-radius: 12px;
    width: 100%;
    max-width: 620px;
    overflow: hidden;
}

.create-card-header {
    background: var(--blue-dark);
    padding: 16px 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.create-card-header .card-icon {
    background: rgba(255,255,255,0.15);
    border-radius: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.create-card-header .card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--white);
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.create-card-header .card-sub {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
}

.create-card-body {
    padding: 24px;
}

.form-grid {
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
    transition: border-color .15s, box-shadow .15s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--blue-dark);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(41, 128, 185, 0.15);
}

.form-divider {
    height: 1px;
    background: var(--blue-pale);
    margin: 4px 0 16px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 8px;
    padding-top: 16px;
    border-top: 1px solid var(--blue-pale);
}

.btn-save {
    background: var(--blue-dark);
    color: var(--white);
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.btn-save:hover { background: var(--blue-mid); }

.btn-cancel {
    background: var(--white);
    color: #e74c3c;
    border: 1px solid #e74c3c;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.btn-cancel:hover { background: #fadbd8; }

.field-error {
    color: #e74c3c;
    font-size: 11px;
    margin-top: 4px;
    display: block;
}
</style>

<div class="create-wrapper">
    <div class="create-card">

        <div class="create-card-header">
            <div>
                <div class="card-title">Schedule an Appointment</div>
                <div class="card-sub">Fill in the details below to create a new appointment</div>
            </div>
        </div>

        <div class="create-card-body">
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label>Patient ID</label>
                        <input type="number" name="patient_id" value="{{ old('patient_id') }}" placeholder="e.g. 1001" required>
                        @error('patient_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Consultant ID</label>
                        <input type="number" name="consultant_id" value="{{ old('consultant_id') }}" placeholder="e.g. 201" required>
                        @error('consultant_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Appointment Date</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                        @error('appointment_date')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Appointment Time</label>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                        @error('appointment_time')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-divider"></div>

                <div class="form-group">
                    <label>Examination Room</label>
                    <input type="text" name="examination_room" value="{{ old('examination_room') }}" placeholder="e.g. Room 3A" required>
                    @error('examination_room')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Save Appointment</button>
                    <a href="{{ route('appointments.index') }}" class="btn-cancel">Cancel</a>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection