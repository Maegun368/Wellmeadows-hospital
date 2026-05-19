@extends('layouts.app')

@section('content')
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background: #EAF1FB;
    font-family: 'Segoe UI', sans-serif;
    color: #1E293B;
}

.profile-wrapper {
    padding: 24px;
    background: #EAF1FB;
    min-height: calc(100vh - 100px);
}

/* ── Top bar ── */
.profile-topbar {
    background: #1a3451;
    padding: 20px 24px;
    border-radius: 12px;
    margin-bottom: 24px;
    color: white;
}

.profile-topbar h1 {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    letter-spacing: 0.3px;
}

.profile-topbar p {
    margin-top: 4px;
    color: #DBEAFE;
    font-size: 12px;
}

/* ── Profile Card Container ── */
.profile-card {
    background: white;
    border: 2px solid #2e86c1;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 24px;
}

/* ── Profile Header ── */
.profile-header {
    background: #2e86c1;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    color: white;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: bold;
    color: #1a3451;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    flex-shrink: 0;
}

.profile-header-info h2 {
    font-size: 22px;
    font-weight: 700;
    margin: 0 0 4px 0;
    letter-spacing: 0.2px;
}

.profile-header-info p {
    margin: 2px 0;
    font-size: 13px;
    color: #DBEAFE;
}

.profile-role-badge {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 14px;
    background: #1a3451;
    color: white;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

/* ── Profile Content ── */
.profile-content {
    padding: 24px;
}

.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.profile-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px;
}

.profile-section-title {
    font-size: 14px;
    font-weight: 700;
    color: #1a3451;
    margin: 0 0 14px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #2e86c1;
}

.profile-info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e2e8f0;
    font-size: 13px;
}

.profile-info-row:last-child {
    border-bottom: none;
}

.profile-info-label {
    color: #666;
    font-weight: 500;
}

.profile-info-value {
    color: #1a3451;
    font-weight: 600;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.status-active {
    background: #e1f5ee;
    color: #085041;
}

.status-verified {
    background: #e1f5ee;
    color: #085041;
}

.status-pending {
    background: #faeeda;
    color: #633806;
}

/* ── Action Buttons ── */
.profile-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    padding: 24px;
    background: white;
    border: 2px solid #2e86c1;
    border-top: none;
    border-radius: 0 0 12px 12px;
}

.profile-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    cursor: pointer;
    border: none;
    transition: opacity 0.15s;
}

.profile-btn-primary {
    background: #2e86c1;
    color: white;
}

.profile-btn-primary:hover {
    opacity: 0.9;
}

.profile-btn-secondary {
    background: #f0f4f8;
    color: #1a3451;
    border: 1px solid #cbd5e0;
}

.profile-btn-secondary:hover {
    background: #e2e8f0;
}

@media (max-width: 768px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-actions {
        grid-template-columns: 1fr;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<div class="profile-wrapper">
    
    <!-- Top Bar -->
    <div class="profile-topbar">
        <h1>My Profile</h1>
        <p>Manage your account information and settings</p>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        
        <!-- Header Section -->
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->name ?? '', ' '), 1, 1)) }}
            </div>
            <div class="profile-header-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
                @if(Auth::user()->getRoleNames()->first())
                    <span class="profile-role-badge">
                        {{ ucfirst(Auth::user()->getRoleNames()->first()) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Content Section -->
        <div class="profile-content">
            <div class="profile-grid">
                
                <!-- Account Information -->
                <div class="profile-section">
                    <h3 class="profile-section-title">Account Information</h3>
                    <div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">Full Name</span>
                            <span class="profile-info-value">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">Email Address</span>
                            <span class="profile-info-value">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">User ID</span>
                            <span class="profile-info-value">#{{ Auth::user()->id }}</span>
                        </div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">Member Since</span>
                            <span class="profile-info-value">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Security Information -->
                <div class="profile-section">
                    <h3 class="profile-section-title">Security & Status</h3>
                    <div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">Account Status</span>
                            <span class="status-badge status-active">Active</span>
                        </div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">Email Verified</span>
                            @if(Auth::user()->email_verified_at)
                                <span class="status-badge status-verified">✓ Verified</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </div>
                        <div class="profile-info-row">
                            <span class="profile-info-label">Last Updated</span>
                            <span class="profile-info-value">{{ Auth::user()->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="profile-actions">
            <button onclick="document.getElementById('editSection').scrollIntoView({behavior: 'smooth'})" class="profile-btn profile-btn-primary">
                Edit Profile
            </button>
            <a href="{{ route('dashboard') }}" class="profile-btn profile-btn-secondary">
                Back to Dashboard
            </a>
        </div>

    </div>

    <!-- Edit Profile Section -->
    <div id="editSection" style="margin-top: 40px;">
        <div class="profile-topbar">
            <h1>Edit Profile</h1>
            <p>Update your account information and settings</p>
        </div>

        <!-- Consolidated Edit Form Card -->
        <div class="profile-card" style="margin-top: 24px;">
            <div class="profile-header" style="background: #1a5276;">
                <div style="color: white; flex: 1;">
                    <h2 style="font-size: 18px; font-weight: 700; margin: 0;">Edit Profile Settings</h2>
                    <p style="margin-top: 4px; color: #DBEAFE; font-size: 12px;">Manage your account information, password, and account settings</p>
                </div>
            </div>
            <div class="profile-content">
                <!-- Profile Information Section -->
                <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid #e2e8f0;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #1a5276; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile Information
                    </h3>
                    <style>
                        /* Form input styling to match site design */
                        .profile-form input[type="text"],
                        .profile-form input[type="email"],
                        .profile-form input[type="password"] {
                            width: 100% !important;
                            padding: 12px 16px !important;
                            border: 2px solid #e2e8f0 !important;
                            border-radius: 8px !important;
                            font-size: 14px !important;
                            color: #1a3451 !important;
                            background: #ffffff !important;
                            transition: all 0.2s !important;
                            box-sizing: border-box !important;
                            margin-top: 8px !important;
                        }
                        .profile-form input[type="text"]:focus,
                        .profile-form input[type="email"]:focus,
                        .profile-form input[type="password"]:focus {
                            outline: none !important;
                            border-color: #2e86c1 !important;
                            box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.1) !important;
                        }
                        .profile-form label {
                            font-size: 13px !important;
                            font-weight: 600 !important;
                            color: #374151 !important;
                            display: block !important;
                        }
                        .profile-form .mt-6 {
                            margin-top: 24px !important;
                        }
                        .profile-form .space-y-6 > * + * {
                            margin-top: 20px !important;
                        }
                        .save-profile-btn {
                            background: #2e86c1 !important;
                            color: white !important;
                            border: none !important;
                            padding: 12px 28px !important;
                            border-radius: 8px !important;
                            font-size: 13px !important;
                            font-weight: 700 !important;
                            cursor: pointer !important;
                            text-transform: uppercase !important;
                            letter-spacing: 0.04em !important;
                            transition: all 0.15s !important;
                            box-shadow: 0 2px 4px rgba(46, 134, 193, 0.2) !important;
                        }
                        .save-profile-btn:hover {
                            background: #1a5276 !important;
                            transform: translateY(-1px) !important;
                            box-shadow: 0 4px 12px rgba(46, 134, 193, 0.3) !important;
                        }
                        .save-password-btn {
                            background: #2e86c1 !important;
                            color: white !important;
                            border: none !important;
                            padding: 12px 28px !important;
                            border-radius: 8px !important;
                            font-size: 13px !important;
                            font-weight: 700 !important;
                            cursor: pointer !important;
                            text-transform: uppercase !important;
                            letter-spacing: 0.04em !important;
                            transition: all 0.15s !important;
                            box-shadow: 0 2px 4px rgba(46, 134, 193, 0.2) !important;
                        }
                        .save-password-btn:hover {
                            background: #1a5276 !important;
                            transform: translateY(-1px) !important;
                            box-shadow: 0 4px 12px rgba(46, 134, 193, 0.3) !important;
                        }
                        .delete-account-btn {
                            background: #e74c3c !important;
                            color: white !important;
                            border: none !important;
                            padding: 12px 28px !important;
                            border-radius: 8px !important;
                            font-size: 13px !important;
                            font-weight: 700 !important;
                            cursor: pointer !important;
                            text-transform: uppercase !important;
                            letter-spacing: 0.04em !important;
                            transition: all 0.15s !important;
                            box-shadow: 0 2px 4px rgba(231, 76, 60, 0.2) !important;
                        }
                        .delete-account-btn:hover {
                            background: #c0392b !important;
                            transform: translateY(-1px) !important;
                            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3) !important;
                        }
                        .profile-form section header h2 {
                            display: none !important;
                        }
                        .profile-form section header p {
                            font-size: 13px !important;
                            color: #64748b !important;
                            margin-bottom: 20px !important;
                            margin-top: 4px !important;
                        }
                    </style>
                    <div class="profile-form">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Section -->
                <div style="margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid #e2e8f0;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #1a5276; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        Update Password
                    </h3>
                    <div class="profile-form">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 24px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #c0392b; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Danger Zone - Delete Account
                    </h3>
                    <div class="profile-form">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <div style="text-align: center; margin-bottom: 40px;">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="profile-btn profile-btn-secondary">
                Back to Top
            </button>
        </div>

    </div>

</div>

@endsection