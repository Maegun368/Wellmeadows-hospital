<x-guest-layout>
    <style>
        .card {
            background: #1a3a5c;
            border-radius: 20px;
            padding: 4rem;
            width: 100%;
            max-width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .hospital-name {
            font-family: Georgia, serif;
            font-size: 20px;
            color: #fff;
            margin-bottom: 2px;
        }
        .hospital-sub {
            font-size: 13px;
            font-weight: 500;
            color: #7ab8f5;
            letter-spacing: 0.12em;
            margin-bottom: 1.75rem;
        }
        .wm-input {
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: none;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 13px;
            outline: none;
            box-sizing: border-box;
        }
        .wm-input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        .btn-login {
            width: 100%;
            padding: 9px;
            border-radius: 8px;
            border: none;
            background: #7ab8f5;
            color: #0c2d4a;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 8px;
        }
        .divider {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.15);
        }
        .divider span {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
            white-space: nowrap;
        }
        .btn-register {
            width: 100%;
            padding: 9px;
            border-radius: 8px;
            border: 1px solid #7ab8f5;
            background: transparent;
            color: #7ab8f5;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            display: block;
            text-decoration: none;
        }
        .btn-register:hover {
            background: rgba(122,184,245,0.1);
        }
        .error-msg {
            color: #f7c1c1;
            font-size: 12px;
            margin-bottom: 0.75rem;
        }
    </style>

    <div class="card">

        {{-- Logo --}}
        <div style="width:60px;height:60px;border-radius:50%;background:rgba(122,184,245,0.18);display:flex;align-items:center;justify-content:center;margin-bottom:0.75rem;">
            <img src="{{ asset('image/wellmeadows-logo.png') }}" alt="Wellmeadows Hospital" style="width:100px;height:100px;border-radius:50px">
        </div>

        <p class="hospital-name">Wellmeadows</p>
        <p class="hospital-sub">HOSPITAL</p>

        {{-- Error Messages --}}
        @if($errors->any())
            <p class="error-msg">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('register') }}" style="width:100%">
            @csrf

            {{-- Name --}}
            <input
                type="text"
                name="name"
                placeholder="Name"
                value="{{ old('name') }}"
                class="wm-input"
                required
                autofocus
                autocomplete="name"
            >

            {{-- Email --}}
            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                class="wm-input"
                required
                autocomplete="username"
            >

            {{-- Password --}}
            <input
                type="password"
                name="password"
                placeholder="Password"
                class="wm-input"
                required
                autocomplete="new-password"
            >

            {{-- Confirm Password --}}
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                class="wm-input"
                required
                autocomplete="new-password"
            >

            {{-- Terms Checkbox --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:1rem">
                <input type="checkbox" id="terms" name="terms" style="accent-color:#7ab8f5" required>
                <label for="terms" style="font-size:12px;color:rgba(255,255,255,0.6)">
                    I agree to the terms
                </label>
            </div>

            {{-- Register Button --}}
            <button type="submit" class="btn-login">
                Create an account
            </button>

        </form>

        {{-- Divider + Login Link --}}
        <div class="divider"><span>or</span></div>
        <a href="{{ route('login') }}" class="btn-register">
            Already have an account?
        </a>

    </div>

</x-guest-layout>