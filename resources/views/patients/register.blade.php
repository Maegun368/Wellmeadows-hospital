<x-guest-layout>

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .reg-card {
            background: #1a3a5c;
            border-radius: 20px;
            padding: 2.5rem 3rem;
            width: 100%;
            max-width: 360px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .reg-card .hospital-name {
            font-family: 'Segoe UI', sans-serif;
            font-size: 20px;
            color: #fff;
            margin-bottom: 2px;
        }
        .reg-card .hospital-sub {
            font-size: 13px;
            font-weight: 500;
            color: #7ab8f5;
            letter-spacing: 0.12em;
            margin-bottom: 1.5rem;
        }
        .reg-card .wm-input {
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
        .reg-card .wm-input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        .reg-card .btn-submit {
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
        .reg-card .btn-outline {
            width: 100%;
            padding: 9px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
            background: transparent;
            color: rgba(255,255,255,0.65);
            font-size: 13px;
            text-align: center;
            display: block;
            text-decoration: none;
        }
        .reg-card .error-msg {
            color: #f7c1c1;
            font-size: 11px;
            margin-top: -6px;
            margin-bottom: 8px;
            width: 100%;
        }
        .reg-card .divider {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0;
        }
        .reg-card .divider::before,
        .reg-card .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.15);
        }
        .reg-card .divider span {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
        }
    </style>

    <div class="reg-card">

        <div style="width:60px;height:60px;border-radius:50%;background:rgba(122,184,245,0.18);display:flex;align-items:cen