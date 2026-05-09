@extends('layouts.app')

@section('title', 'Create Ward')

@section('content')

<div style="max-width:700px;margin:auto;">

    <div style="
        background:white;
        padding:24px;
        border-radius:16px;
        border:1px solid #dbe7f3;
    ">

        <h1 style="
            font-size:28px;
            font-weight:700;
            margin-bottom:20px;
            color:#1e3a5f;
        ">
            Create New Ward
        </h1>

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

        <form action="{{ route('wards.store') }}"
              method="POST">

            @csrf

            <div style="margin-bottom:18px;">

                <label style="display:block;margin-bottom:6px;font-weight:600;">
                    Ward Name
                </label>

                <input type="text"
                       name="ward_name"
                       value="{{ old('ward_name') }}"
                       required
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #cbd5e0;
                            border-radius:10px;
                       ">

            </div>

            <div style="margin-bottom:18px;">

                <label style="display:block;margin-bottom:6px;font-weight:600;">
                    Location
                </label>

                <input type="text"
                       name="location"
                       value="{{ old('location') }}"
                       required
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #cbd5e0;
                            border-radius:10px;
                       ">

            </div>

            <div style="margin-bottom:18px;">

                <label style="display:block;margin-bottom:6px;font-weight:600;">
                    Total Beds
                </label>

                <input type="number"
                       name="total_beds"
                       value="{{ old('total_beds') }}"
                       required
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #cbd5e0;
                            border-radius:10px;
                       ">

            </div>

            <div style="margin-bottom:18px;">

                <label style="display:block;margin-bottom:6px;font-weight:600;">
                    Telephone Extension
                </label>

                <input type="text"
                       name="telephone_extension"
                       value="{{ old('telephone_extension') }}"
                       required
                       style="
                            width:100%;
                            padding:12px;
                            border:1px solid #cbd5e0;
                            border-radius:10px;
                       ">

            </div>

            <div style="display:flex;gap:10px;">

                <button type="submit"
                        style="
                            background:#1e3a5f;
                            color:white;
                            border:none;
                            padding:12px 20px;
                            border-radius:10px;
                            cursor:pointer;
                            font-weight:600;
                        ">

                    Save Ward

                </button>

                <a href="{{ route('wards.index') }}"
                   style="
                        background:#e5e7eb;
                        color:#374151;
                        padding:12px 20px;
                        border-radius:10px;
                        text-decoration:none;
                        font-weight:600;
                   ">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection