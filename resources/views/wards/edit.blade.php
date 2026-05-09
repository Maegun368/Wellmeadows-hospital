@extends('layouts.app')

@section('title', 'Edit Ward')

@section('content')

<style>

    .form-container{
        max-width:700px;
        margin:auto;
    }

    .panel{
        background:white;
        border-radius:16px;
        padding:24px;
        border:1px solid #dbe7f3;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);
    }

    .panel-title{
        font-size:28px;
        font-weight:700;
        color:#1e3a5f;
        margin-bottom:20px;
    }

    .form-group{
        margin-bottom:18px;
    }

    .form-group label{
        display:block;
        margin-bottom:6px;
        font-size:14px;
        font-weight:600;
        color:#1e3a5f;
    }

    .form-group input{
        width:100%;
        padding:12px;
        border-radius:10px;
        border:1px solid #cbd5e0;
        font-size:14px;
    }

    .btn-main{
        background:#1e3a5f;
        color:white;
        padding:12px 20px;
        border:none;
        border-radius:10px;
        cursor:pointer;
        font-weight:600;
    }

    .btn-cancel{
        background:#e5e7eb;
        color:#374151;
        padding:12px 20px;
        border-radius:10px;
        text-decoration:none;
        font-weight:600;
    }

    .btn-group{
        display:flex;
        gap:10px;
        margin-top:20px;
    }

</style>

<div class="form-container">

    <div class="panel">

        <div class="panel-title">
            Edit Ward
        </div>

        @if ($errors->any())

            <div style="
                background:#fee2e2;
                color:#991b1b;
                padding:12px;
                border-radius:10px;
                margin-bottom:20px;
            ">

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route('wards.update', $ward->ward_id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Ward Name</label>

                <input type="text"
                       name="ward_name"
                       value="{{ old('ward_name', $ward->ward_name) }}"
                       required>

            </div>

            <div class="form-group">

                <label>Location</label>

                <input type="text"
                       name="location"
                       value="{{ old('location', $ward->location) }}"
                       required>

            </div>

            <div class="form-group">

                <label>Total Beds</label>

                <input type="number"
                       name="total_beds"
                       value="{{ old('total_beds', $ward->total_beds) }}"
                       required>

            </div>

            <div class="form-group">

                <label>Telephone Extension</label>

                <input type="text"
                       name="telephone_extension"
                       value="{{ old('telephone_extension', $ward->telephone_extension) }}"
                       required>

            </div>

            <div class="btn-group">

                <button type="submit"
                        class="btn-main">

                    Update Ward

                </button>

                <a href="{{ route('wards.index') }}"
                   class="btn-cancel">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection