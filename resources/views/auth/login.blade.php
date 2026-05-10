<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        body {
            background: #e8d5d8 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: #1a3a5c;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 340px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
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
            box-sizing: border-box;  /* FIXED */
            display: block;          /* FIXED */
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
            box-sizing: border-box;  /* FIXED */
            display: block;          /* FIXED */
        }
        .btn-forgot {
            width: 100%;
            padding: 9px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
            background: transparent;
            color: rgba(255,255,255,0.65);
            font-size: 13px;
            cursor: pointer;
            text-align: center;
            display: block;
            box-sizing: border-box;  /* FIXED */
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
            box-sizing: border-box;  /* FIXED */
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
        <div style="width:60px;height:60px;border-radius:50%;background:rgba(122,184,245,0.18);display:flex;align-items:center;justify-content:center;margin-bottom:0.75rem;">
            <img src="{{ asset('image/wellmeadows-logo.png') }}" alt="Wellmeadows Hospital" style="width:100px;height:100px;border-radius:50px">
        </div>
        <p class="hospital-name">Wellmeadows</p>
        <p class="hospital-sub">HOSPITAL</p>

        @if($errors->any())
            <p class="error-msg">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}" style="width:100%;box-sizing:border-box;">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                class="wm-input"
                required
                autofocus
                autocomplete="username"
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="wm-input"
                required
                autocomplete="current-password"
            >

            <div style="display:flex;align-items:center;gap:8px;margin-bottom:1rem">
                <input type="checkbox" id="remember_me" name="remember" style="accent-color:#7ab8f5">
                <label for="remember_me" style="font-size:12px;color:rgba(255,255,255,0.6)">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-login">Log in</button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="btn-forgot">
                    Forgot password?
                </a>
            @endif

        </form>

        @if (Route::has('register'))
            <div class="divider"><span>or</span></div>
            <a href="{{ route('register') }}" class="btn-register">
                Create an account
            </a>
        @endif

    </div>

</x-guest-layout>