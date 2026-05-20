@extends('layouts.app')

@section('title', 'Edit Ward')

@section('content')

<style>
:root{
    --blue-dark:#1a5276;
    --blue-mid:#2e86c1;
    --blue-light:#5dade2;
    --blue-accent:#2980b9;
    --blue-pale:#d6eaf8;
    --blue-bg:#e8f4fd;
    --white:#ffffff;
}

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    background:var(--blue-bg);
    font-family:'Open Sans',sans-serif;
    color:#2d3748;
}

.wbm-wrapper{
    background:var(--blue-bg);
    min-height:100vh;
    padding-bottom:40px;
}

/* ───── TOPBAR ───── */
.wbm-topbar{
    background:var(--blue-dark);
    padding:14px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
}

.wbm-topbar h1{
    font-size:18px;
    font-weight:700;
    color:white;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.wbm-topbar p{
    color:rgba(255,255,255,.55);
    font-size:11px;
    margin-top:2px;
}

.wbm-back-btn{
    background:rgba(255,255,255,.15);
    border:1px solid rgba(255,255,255,.3);
    color:white;
    padding:9px 16px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
}

.wbm-back-btn:hover{
    background:rgba(255,255,255,.25);
}

/* ───── CONTENT ───── */
.wbm-content{
    padding:24px;
    max-width:680px;
    margin:0 auto;
}

/* ───── PANEL ───── */
.wbm-panel{
    background:white;
    border:2px solid var(--blue-mid);
    border-radius:12px;
    overflow:hidden;
}

.wbm-panel-title{
    background:var(--blue-mid);
    color:white;
    padding:10px 16px;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
}

.wbm-panel-body{
    padding:24px;
}

/* ───── ALERT ───── */
.wbm-alert-error{
    background:#fee2e2;
    color:#991b1b;
    padding:12px 16px;
    border-radius:8px;
    margin-bottom:20px;
    font-size:13px;
}

.wbm-alert-error ul{
    margin:0;
    padding-left:16px;
}

/* ───── FORM ───── */
.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
    color:var(--blue-dark);
}

.form-group input{
    width:100%;
    padding:11px 14px;
    border-radius:8px;
    border:1px solid var(--blue-pale);
    font-size:14px;
    color:#2d3748;
    background:#f8fbff;
    transition:border-color .15s, box-shadow .15s;
}

.form-group input:focus{
    outline:none;
    border-color:var(--blue-mid);
    box-shadow:0 0 0 3px rgba(46,134,193,.15);
    background:white;
}

/* ───── BUTTONS ───── */
.btn-group{
    display:flex;
    gap:10px;
    margin-top:24px;
}

.wbm-btn{
    padding:10px 20px;
    border-radius:8px;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
    border:none;
    text-decoration:none;
    display:inline-block;
}

.wbm-btn-submit{
    background:var(--blue-dark);
    color:white;
}

.wbm-btn-submit:hover{
    background:#154360;
}

.wbm-btn-cancel{
    background:#f0f8ff;
    color:var(--blue-dark);
    border:1px solid var(--blue-pale);
}

.wbm-btn-cancel:hover{
    background:var(--blue-pale);
}

/* ───── BACK BUTTON ROW ───── */
.wbm-back-row{
    padding:0 16px 16px;
    display:flex;
    justify-content:flex-start;
}

.wbm-back-row a{
    background:var(--blue-dark);
    color:white;
    padding:9px 18px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    display:inline-block;
}

.wbm-back-row a:hover{
    opacity:.9;
}

</style>

<div class="wbm-wrapper">

    {{-- TOPBAR --}}
    <div class="wbm-topbar">
        <div>
            <h1>✏️ Edit Ward</h1>
            <p>{{ now()->format('F d, Y | h:i A') }}</p>
        </div>
    </div>

    {{-- FORM --}}
    <div class="wbm-content">
        <div class="wbm-panel">
            <div class="wbm-panel-title">Ward Information</div>
            <div class="wbm-panel-body">

                @if ($errors->any())
                    <div class="wbm-alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('wards.update', $ward->ward_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Ward Name</label>
                        <input type="text"
                               name="ward_name"
                               value="{{ old('ward_name', $ward->ward_name) }}"
                               placeholder="e.g. General Medicine"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text"
                               name="location"
                               value="{{ old('location', $ward->location) }}"
                               placeholder="e.g. Building A, Floor 3"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Total Beds</label>
                        <input type="number"
                               name="total_beds"
                               value="{{ old('total_beds', $ward->total_beds) }}"
                               placeholder="e.g. 20"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Telephone Extension</label>
                        <input type="text"
                               name="telephone_extension"
                               value="{{ old('telephone_extension', $ward->telephone_extension) }}"
                               placeholder="e.g. 1045"
                               required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="wbm-btn wbm-btn-submit">
                            Update Ward
                        </button>
                        <a href="{{ route('wards.index') }}" class="wbm-btn wbm-btn-cancel">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
        {{-- BACK BUTTON (below table) --}}
            <div class="wbm-back-row">
                <a href="{{ route('wards.index') }}">← Back to Ward & Bed Management</a>
            </div>
</div>

@endsection