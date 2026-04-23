@extends('staff.layout.app')

@section('title', 'Staff Profile')
@section('page_title', 'My Profile')

@section('extra_css')
<style>
    .profile-grid { display: grid; grid-template-columns: 300px 1fr; gap: 24px; }
    .avatar-upload { position: relative; width: 180px; height: 180px; margin: 0 auto 20px; }
    .avatar-preview { width: 100%; height: 100%; border-radius: 50%; border: 3px solid var(--border); display: flex; align-items: center; justify-content: center; background-color: var(--bg-card); overflow: hidden; position: relative; }
    .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-action { position: absolute; bottom: 5px; width: 36px; height: 36px; border-radius: 50%; background: var(--gold-bright); color: #000; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid var(--bg-panel); transition: transform 0.2s; z-index: 10; }
    .avatar-edit { right: 5px; }
    .avatar-download { left: 5px; }
    .avatar-action:hover { transform: scale(1.1); }
    .info-group { margin-bottom: 20px; }
    .info-label { font-size: 11px; color: var(--gold-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .info-value { font-size: 15px; color: var(--cream); font-weight: 500; }
    @media (max-width: 860px) { .profile-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('staff.dashboard') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Dashboard
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold-mid)">Staff Profile</h1>
        <p class="text-sm" style="color:var(--gold-muted)">Manage your staff account details</p>
    </div>
</div>

<div class="profile-grid">
    {{-- Left Column: Avatar & Quick Info --}}
    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="card" style="padding:32px 24px; text-align:center;">
                <form action="{{ route('staff.profile.update') }}" method="POST" id="avatarForm" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    
                    {{-- Carry existing values to pass validation --}}
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="first_name" value="{{ $member?->FirstName }}">
                    <input type="hidden" name="last_name" value="{{ $member?->LastName }}">
                    <input type="hidden" name="phone_number" value="{{ $member?->PhoneNumber }}">
                    <input type="hidden" name="date_of_birth" value="{{ $member?->DateOfBirth ? $member->DateOfBirth->format('Y-m-d') : '' }}">

                    <div class="avatar-upload">
                    @php 
                        $profilePic = $member ? $member->profile_picture : null; 
                        $avatarUrl = $profilePic ? asset('storage/'.$profilePic) : null;
                    @endphp
                    <div class="avatar-preview" id="imagePreview">
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Profile Picture">
                            <a href="{{ $avatarUrl }}" download="profile_picture_{{ $user->id }}.jpg" class="avatar-action avatar-download" title="Download Profile Picture">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                        @else
                            <span style="font-size:64px; font-family:Georgia, serif; color:var(--gold-muted);">{{ strtoupper(substr($user->name ?? 'S', 0, 1)) }}</span>
                        @endif
                    </div>
                    <label for="profile_picture" class="avatar-action avatar-edit" title="Upload New Picture">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="file" name="profile_picture" id="profile_picture" style="display:none;" onchange="this.form.submit()">
                    </label>
                </div>
            </form>
            <h2 style="font-family:Georgia, serif; font-size:22px; color:var(--gold-mid); margin-bottom:4px;">{{ $user->name }}</h2>
            <div style="font-size:12px; color:var(--gold-muted); margin-bottom:12px;">{{ ucfirst($user->role) }} Account</div>
        </div>
    </div>

    {{-- Right Column: Edit Form --}}
    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="card" style="padding:32px;">
            <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--gold-mid); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Personal Information
            </h3>

            <form action="{{ route('staff.profile.update') }}" method="POST">
                @csrf @method('PATCH')
                
                <div style="margin-bottom:24px;">
                    <label class="info-label">Display Name *</label>
                    <input type="text" name="name" class="form-input @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="info-label">First Name</label>
                        <input type="text" name="first_name" class="form-input" value="{{ old('first_name', $member?->FirstName) }}">
                    </div>
                    <div>
                        <label class="info-label">Last Name</label>
                        <input type="text" name="last_name" class="form-input" value="{{ old('last_name', $member?->LastName) }}">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="info-label">Email Address *</label>
                    <input type="email" name="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="info-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-input" value="{{ old('phone_number', $member?->PhoneNumber) }}">
                    </div>
                    <div>
                        <label class="info-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-input" value="{{ old('date_of_birth', $member?->DateOfBirth ? $member->DateOfBirth->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="submit" class="btn btn-gold">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="card" style="padding:32px;">
            <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--accent); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Change Password
            </h3>

            <form action="{{ route('staff.profile.password') }}" method="POST">
                @csrf @method('PATCH')
                
                <div style="margin-bottom:24px;">
                    <label class="info-label">Current Password *</label>
                    <input type="password" name="current_password" class="form-input @error('current_password') border-red-500 @enderror" required>
                    @error('current_password') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
                </div>

                <div style="margin-bottom:24px;">
                    <label class="info-label">New Password *</label>
                    <input type="password" name="new_password" class="form-input @error('new_password') border-red-500 @enderror" required>
                    @error('new_password') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
                </div>

                <div style="margin-bottom:32px;">
                    <label class="info-label">Confirm New Password *</label>
                    <input type="password" name="new_password_confirmation" class="form-input" required>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="submit" class="btn btn-ghost" style="color:var(--accent); border-color:var(--accent);">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
