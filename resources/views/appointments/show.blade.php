@extends('layouts.app')
@section('title', 'Appointment Details')
@section('topbar-actions')
    <a href="{{ route('appointments.index') }}" class="btn">Back</a>
    <a href="{{ route('appointments.edit', $appointment->appointment_id) }}" class="btn" style="margin-left:8px">Edit Appointment</a>
    @if($appointment->outcome)
        <span class="btn" style="margin-left:8px; background:#10b981; color:white; border-color:#10b981;">Outcome: {{ ucfirst($appointment->outcome) }}</span>
    @endif
@endsection
@section('content')

@if(session('success'))
    <div class="card" style="margin-bottom:1rem; background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width:640px; margin: 2rem auto;">
    <div class="card-title">Appointment #{{ $appointment->appointment_id }}</div>
    <div style="padding:0 24px 24px;">
        <table style="width:100%; border-collapse:collapse; margin-bottom:1.5rem;">
            <tbody>
                <tr>
                    <th style="width:40%; text-align:left; padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Patient ID</th>
                    <td style="padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#2d3748;">{{ $appointment->patient_id }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Consultant ID</th>
                    <td style="padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#2d3748;">{{ $appointment->consultant_id }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Date</th>
                    <td style="padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#2d3748;">{{ $appointment->appointment_date }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Time</th>
                    <td style="padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#2d3748;">{{ $appointment->appointment_time }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Room</th>
                    <td style="padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#2d3748;">{{ $appointment->examination_room }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Status</th>
                    <td style="padding:12px 8px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#2d3748;">{{ $appointment->status ?? 'Waiting' }}</td>
                </tr>
                @if($appointment->outcome)
                <tr>
                    <th style="text-align:left; padding:12px 8px; font-size:12px; text-transform:uppercase; letter-spacing:0.04em; color:var(--blue-dark);">Outcome</th>
                    <td style="padding:12px 8px; font-size:14px; color:#2d3748;"><span style="background:#d1fae5; color:#065f46; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">{{ ucfirst($appointment->outcome) }}</span></td>
                </tr>
                @endif
            </tbody>
        </table>
        
        <div style="display:flex; gap:12px; align-items:center;">
            <a href="{{ route('appointments.index') }}" class="btn">Back</a>
            @if(!$appointment->outcome)
                <button onclick="openOutcomeModal()" class="btn btn-primary">Set Appointment Outcome</button>
            @endif
            <form method="POST" action="{{ route('appointments.destroy', $appointment->appointment_id) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel appointment</button>
            </form>
        </div>
    </div>
</div>

<style>
/* Modal styles matching the site's theme */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 30, 50, 0.55);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; }

.outcome-modal {
    background: #ffffff;
    border-radius: 14px;
    width: 100%;
    max-width: 420px;
    margin: 0 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    animation: slideUp .2s ease;
}
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

.outcome-modal-header {
    background: var(--blue-dark);
    padding: 16px 20px;
    display:flex; align-items:center; justify-content:space-between;
}
.outcome-modal-header h3 {
    color: var(--white);
    font-size: 14px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.outcome-modal-header .close-btn {
    background:none; border:none; color:var(--white); font-size:20px; cursor:pointer;
    padding:0; line-height:1;
}

.outcome-modal-body {
    padding: 24px;
}
.outcome-modal-body p.intro {
    color:#4a5568; margin:0 0 20px; font-size:14px;
}

.outcome-btn {
    width:100%;
    padding:16px;
    border:2px solid #e2e8f0;
    border-radius:8px;
    background:#ffffff;
    text-align:left;
    cursor:pointer;
    transition:all 0.2s;
    margin-bottom:12px;
}
.outcome-btn:last-child { margin-bottom:20px; }
.outcome-btn:hover { border-color:var(--blue-dark); background:#f8fafc; }
.outcome-btn.selected { border-color:var(--blue-dark); background:#eff6ff; }
.outcome-btn .title { font-weight:600; color:var(--blue-dark); font-size:14px; display:block; }
.outcome-btn .desc { font-size:12px; color:#718096; margin-top:4px; display:block; line-height:1.4; }

.selected-description {
    display:none;
    background:#f0f4f8;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}
.selected-description p { margin:0; font-size:13px; color:#2d3748; }

.confirm-btn {
    width:100%;
    padding:12px;
    background:var(--blue-dark);
    color:var(--white);
    border:none;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
    opacity:0.5;
    transition:opacity 0.2s;
}
.confirm-btn:enabled { opacity:1; }
</style>

<!-- Outcome Modal -->
<div id="outcomeModal" class="modal-overlay">
    <div class="outcome-modal">
        <div class="outcome-modal-header">
            <h3>Set Appointment Outcome</h3>
            <button onclick="closeOutcomeModal()" class="close-btn">&times;</button>
        </div>
        <div class="outcome-modal-body">
            <p class="intro">Select the appropriate outcome for this patient after examination:</p>
            
            <form id="outcomeForm" method="POST" action="{{ route('appointments.outcome', $appointment->appointment_id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="outcome" id="outcomeInput" value="">
                
                <button type="button" onclick="selectOutcome('ward', this)" class="outcome-btn">
                    <span class="title">Assign to Ward</span>
                    <span class="desc">Redirect to bed & ward management to assign a bed</span>
                </button>
                
                <button type="button" onclick="selectOutcome('outpatient', this)" class="outcome-btn">
                    <span class="title">Out-patient Clinic</span>
                    <span class="desc">Schedule patient for follow-up in the outpatient clinic</span>
                </button>
                
                <button type="button" onclick="selectOutcome('discharge', this)" class="outcome-btn">
                    <span class="title">Discharge Patient</span>
                    <span class="desc">Patient is cleared for discharge - no further treatment needed</span>
                </button>
                
                <div id="selectedDescription" class="selected-description">
                    <p id="descriptionText"></p>
                </div>
                
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:8px;">
                    <button type="button" onclick="closeOutcomeModal()" style="padding:12px; background:#f3f4f6; color:#374151; border:none; border-radius:8px; font-weight:600; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        Cancel
                    </button>
                    <button type="submit" id="confirmBtn" disabled class="confirm-btn">
                        Confirm Outcome
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const outcomeDescriptions = {
    ward: 'Patient will be redirected to Ward & Bed Management where you can assign a bed.',
    outpatient: 'Patient will be scheduled in the outpatient clinic for follow-up care.',
    discharge: 'Patient will be marked as discharged and the appointment will be resolved.'
};

function openOutcomeModal() {
    document.getElementById('outcomeModal').classList.add('open');
}

function closeOutcomeModal() {
    document.getElementById('outcomeModal').classList.remove('open');
    resetSelections();
}

function resetSelections() {
    document.querySelectorAll('.outcome-btn').forEach(btn => {
        btn.classList.remove('selected');
    });
    document.getElementById('selectedDescription').style.display = 'none';
    document.getElementById('confirmBtn').disabled = true;
    document.getElementById('confirmBtn').style.opacity = '0.5';
    document.getElementById('outcomeInput').value = '';
}

function selectOutcome(outcome, btn) {
    resetSelections();
    
    // Set selected state
    btn.classList.add('selected');
    
    // Show description
    document.getElementById('selectedDescription').style.display = 'block';
    document.getElementById('descriptionText').textContent = outcomeDescriptions[outcome];
    
    // Enable confirm button
    document.getElementById('confirmBtn').disabled = false;
    document.getElementById('confirmBtn').style.opacity = '1';
    
    // Set hidden input
    document.getElementById('outcomeInput').value = outcome;
}

// Close modal when clicking outside
document.getElementById('outcomeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOutcomeModal();
    }
});
</script>

@endsection