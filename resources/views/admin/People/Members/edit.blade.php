@extends('admin.layout.app')
@section('title', 'Edit Member — Grace Church CMS')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.members.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.75rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">Edit Member</h1>
</div>

<div class="card p-6 max-w-2xl">
    @if($errors->any())
        <div class="alert-error mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.members.update', $member) }}">
        @csrf @method('PATCH')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">First Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="FirstName" value="{{ old('FirstName', $member->FirstName) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Last Name <span style="color:var(--red)">*</span></label>
                <input type="text" name="LastName" value="{{ old('LastName', $member->LastName) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Email</label>
                <input type="email" name="Email" value="{{ old('Email', $member->Email) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Phone Number</label>
                <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $member->PhoneNumber) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                <select name="Status" class="form-input" required>
                    <option value="Active"   {{ old('Status', $member->Status) === 'Active'   ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('Status', $member->Status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Pending"  {{ old('Status', $member->Status) === 'Pending'  ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div>
                <label class="form-label">Family</label>
                <select name="FamilyID" class="form-input">
                    <option value="">— None —</option>
                    @foreach($families as $family)
                        <option value="{{ $family->FamilyID }}" {{ old('FamilyID', $member->FamilyID) == $family->FamilyID ? 'selected' : '' }}>
                            {{ $family->FamilyName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Role</label>
                <select name="RoleID" class="form-input">
                    <option value="">— None —</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->RoleID }}" {{ old('RoleID', $member->RoleID) == $role->RoleID ? 'selected' : '' }}>
                            {{ $role->RoleName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">New Password</label>
                <input type="password" name="Password" class="form-input" placeholder="Leave blank to keep current">
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="btn btn-gold">Update Member</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
