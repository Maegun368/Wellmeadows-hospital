@extends('layouts.app')

@section('content')

<form action="{{ route('staff.store') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-title">New Staff Member</div>

        <div class="form-grid">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>

            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" required>
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" required>
            </div>

            <div class="form-group">
                <label>Sex</label>
                <select name="sex" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Current Salary</label>
                <input type="number" name="current_salary" required>
            </div>

            <div class="form-group">
                <label>Hours Per Week</label>
                <input type="number" name="hours_per_week" required>
            </div>

            <div class="form-group">
                <label>Contract Type</label>
               <select name="contract_type" required>
    <option value="Full-time">Full-time</option>
    <option value="Part-time">Part-time</option>
</select> 
            </div>
         
          <div class="form-group">
    <label>Pay Type</label>
    <select name="pay_type" required>
    <option value="Monthly">Monthly</option>
    <option value="Weekly">Weekly</option>
</select>
</div>

<div class="form-group">
    <label>NIN</label>
    <input type="text" name="NIN" required>
</div>
    
    <div class="form-group">
    <label>Salary Scale</label>
    <input type="text" name="salary_scale" required>
</div>

        </div>

        <div style="margin-top:20px;">
            <button type="submit" class="btn-save">
                Save Staff Member
            </button>
        </div>

    </div>

</form>

@endsection