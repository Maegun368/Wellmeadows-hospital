@extends('layouts.app')
@section('title', 'Appointment Details')
@section('topbar-actions')
    <a href="{{ route('appointments.index') }}" class="btn">Back</a>
    <a href="{{ route('appointments.edit', $appointment->appointment_id) }}" class="btn" style="margin-left:8px">Edit</a>
@endsection
@section('content')

@if(session('success'))
    <div class="card" style="margin-bottom:1rem; background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width:520px">
    <div class="card-title">Appointment #{{ $appointment->appointment_id }}</div>
    <table>
        <tr><th style="width:40%">Patient ID</th><td>{{ $appointment->patient_id }}</td></tr>
        <tr><th>Consultant ID</th><td>{{ $appointment->consultant_id }}</td></tr>
        <tr><th>Date</th><td>{{ $appointment->appointment_date }}</td></tr>
        <tr><th>Time</th><td>{{ $appointment->appointment_time }}</td></tr>
        <tr><th>Room</th><td>{{ $appointment->examination_room }}</td></tr>
        <tr><th>Status</th><td>{{ $appointment->status ?? 'Waiting' }}</td></tr>
        @if($appointment->outcome)
        <tr><th>Outcome</th><td>{{ ucfirst($appointment->outcome) }}</td></tr>
        @endif
    </table>
    
    <!-- Show outcome button only if outcome not yet set -->
    @if(!$appointment->outcome)
    <div style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid #e2e8f0;">
        <button onclick="openOutcomeModal()" class="btn btn-primary" style="background: #1a2a4a; border-color: #1a2a4a;">
            Set Appointment Outcome
        </button>
    </div>
    @endif
    
    <div style="margin-top:1rem">
        <form method="POST" action="{{ route('appointments.destroy', $appointment->appointment_id) }}" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel appointment</button>
        </form>
    </div>
</div>

<!-- Outcome Modal -->
<div id="outcomeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; max-width:500px; width:90%; overflow:hidden; border:2px solid #1a2a4a;">
        <div style="background:#1a2a4a; padding:16px 24px; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="color:white; margin:0; font-size:16px; text-transform:uppercase; letter-spacing:0.05em;">Set Appointment Outcome</h3>
            <button onclick="closeOutcomeModal()" style="background:none; border:none; color:white; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:24px;">
            <p style="color:#4a5568; margin-bottom:20px; font-size:14px;">Select the appropriate outcome for this patient after examination:</p>
            
            <form id="outcomeForm" method="POST" action="{{ route('appointments.outcome', $appointment->appointment_id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="outcome" id="outcomeInput" value="">
                
                <div style="display:grid; gap:12px; margin-bottom:24px;">
                    <button type="button" onclick="selectOutcome('ward', this)" class="outcome-btn" style="padding:16px; border:2px solid #e2e8f0; border-radius:8px; background:white; text-align:left; cursor:pointer; transition:all 0.2s;">
                        <div style="font-weight:600; color:#1a2a4a; font-size:14px;">Assign to Ward</div>
                        <div style="font-size:12px; color:#718096; margin-top:4px;">Add patient to the ward waiting list for admission</div>
                    </button>
                    
                    <button type="button" onclick="selectOutcome('outpatient', this)" class="outcome-btn" style="padding:16px; border:2px solid #e2e8f0; border-radius:8px; background:white; text-align:left; cursor:pointer; transition:all 0.2s;">
                        <div style="font-weight:600; color:#1a2a4a; font-size:14px;">Out-patient Clinic</div>
                        <div style="font-size:12px; color:#718096; margin-top:4px;">Schedule patient for follow-up in the outpatient clinic</div>
                    </button>
                    
                    <button type="button" onclick="selectOutcome('discharge', this)" class="outcome-btn" style="padding:16px; border:2px solid #e2e8f0; border-radius:8px; background:white; text-align:left; cursor:pointer; transition:all 0.2s;">
                        <div style="font-weight:600; color:#1a2a4a; font-size:14px;">Discharge Patient</div>
                        <div style="font-size:12px; color:#718096; margin-top:4px;">Patient is cleared for discharge - no further treatment needed</div>
                    </button>
                </div>
                
                <div id="selectedDescription" style="display:none; background:#f0f4f8; padding:12px; border-radius:8px; margin-bottom:20px;">
                    <p id="descriptionText" style="margin:0; font-size:13px; color:#2d3748;"></p>
                </div>
                
                <button type="submit" id="confirmBtn" disabled style="width:100%; padding:12px; background:#1a2a4a; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; opacity:0.5;">
                    Confirm Outcome
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const outcomeDescriptions = {
    ward: 'Patient will be added to the ward waiting list and redirected to Ward & Bed Management.',
    outpatient: 'Patient will be scheduled in the outpatient clinic for follow-up care.',
    discharge: 'Patient will be marked as discharged and the appointment will be resolved.'
};

function openOutcomeModal() {
    document.getElementById('outcomeModal').style.display = 'flex';
}

function closeOutcomeModal() {
    document.getElementById('outcomeModal').style.display = 'none';
    resetSelections();
}

function resetSelections() {
    document.querySelectorAll('.outcome-btn').forEach(btn => {
        btn.style.borderColor = '#e2e8f0';
        btn.style.background = 'white';
    });
    document.getElementById('selectedDescription').style.display = 'none';
    document.getElementById('confirmBtn').disabled = true;
    document.getElementById('confirmBtn').style.opacity = '0.5';
    document.getElementById('outcomeInput').value = '';
}

function selectOutcome(outcome, btn) {
    resetSelections();
    
    // Set selected state
    btn.style.borderColor = '#1a2a4a';
    btn.style.background = '#f0f8ff';
    
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