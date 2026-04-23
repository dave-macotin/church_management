@extends('member.layout.app')

@section('title', 'My Profile')
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
</style>
@endsection

@section('content')
<div class="profile-grid">
    {{-- Left Column: Avatar & Quick Info --}}
    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="card" style="padding:32px 24px; text-align:center;">
            <form action="{{ route('member.profile.update') }}" method="POST" id="avatarForm" enctype="multipart/form-data">
                @csrf
                
                {{-- Carry existing values to pass validation --}}
                <input type="hidden" name="FirstName" value="{{ $member->FirstName }}">
                <input type="hidden" name="LastName" value="{{ $member->LastName }}">
                <input type="hidden" name="Email" value="{{ $member->Email }}">
                <input type="hidden" name="PhoneNumber" value="{{ $member->PhoneNumber }}">

                <div class="avatar-upload">
                    @php 
                        $profilePic = $member->profile_picture;
                        $avatarUrl = $profilePic ? asset('storage/'.$profilePic) : null;
                    @endphp
                    <div class="avatar-preview" id="imagePreview">
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Profile Picture">
                            <a href="{{ $avatarUrl }}" download="profile_picture_{{ $member->MemberID }}.jpg" class="avatar-action avatar-download" title="Download Profile Picture">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                        @else
                            <span style="font-size:64px; font-family: 'Outfit', sans-serif; color:var(--gold-mid); font-weight:700;">{{ strtoupper(substr($member->FirstName, 0, 1)) }}</span>
                        @endif
                    </div>
                    <label for="profile_picture" class="avatar-action avatar-edit" title="Upload New Picture">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="file" name="profile_picture" id="profile_picture" style="display:none;" onchange="this.form.submit()">
                    </label>
                </div>
            </form>
            <h2 style="font-family:Georgia, serif; font-size:22px; color:var(--gold-mid); margin-bottom:4px;">{{ $member->FirstName }} {{ $member->LastName }}</h2>
            <div style="font-size:12px; color:var(--gold-muted); margin-bottom:12px;">Active Member</div>
            <div style="display:flex; justify-content:center; gap:8px;">
                <span class="badge badge-amber">{{ $member->role->RoleName ?? 'Member' }}</span>
            </div>
        </div>

        <div class="card" style="padding:20px;">
            <div class="info-group">
                <div class="info-label">Member Since</div>
                <div class="info-value">{{ $member->created_at?->format('F d, Y') ?? 'N/A' }}</div>
            </div>
            <div class="info-group" style="margin-bottom:0;">
                <div class="info-label">Group</div>
                <div class="info-value">{{ $member->role->group->GroupName ?? 'No Group' }}</div>
            </div>
        </div>
    </div>

    {{-- Right Column: Edit Form --}}
    <div class="card" style="padding:32px;">
        <h3 style="font-family:Georgia, serif; font-size:18px; color:var(--gold-mid); margin-bottom:24px; display:flex; align-items:center; gap:10px;">
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Personal Information
        </h3>

        <form action="{{ route('member.profile.update') }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
                <div>
                    <label class="info-label">First Name</label>
                    <input type="text" name="FirstName" class="form-input" value="{{ old('FirstName', $member->FirstName) }}" required>
                    @error('FirstName') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
                </div>
                <div>
                    <label class="info-label">Last Name</label>
                    <input type="text" name="LastName" class="form-input" value="{{ old('LastName', $member->LastName) }}" required>
                    @error('LastName') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label class="info-label">Email Address</label>
                <input type="email" name="Email" class="form-input" value="{{ old('Email', $member->Email) }}" required>
                @error('Email') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom:32px;">
                <label class="info-label">Phone Number</label>
                <input type="text" name="PhoneNumber" class="form-input" value="{{ old('PhoneNumber', $member->PhoneNumber) }}">
                @error('PhoneNumber') <small style="color:var(--red); font-size:11px;">{{ $message }}</small> @enderror
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <button type="submit" class="btn btn-gold">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
