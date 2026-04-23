@extends('admin.Layout.app')
@section('title', 'System Settings — Grace Church CMS')

@section('content')
<div class="mb-6">
    <h1 class="font-cinzel text-2xl" style="color:var(--gold)">System Settings</h1>
    <p class="text-sm mt-1" style="color:var(--text-muted)">Configure church branding and contact information</p>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- General Section --}}
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold)">General Branding</h3>
            
            <div class="mb-4">
                <label class="form-label">Church Name</label>
                <input type="text" name="church_name" value="{{ $settings['church_name'] ?? 'Grace Church' }}" class="form-input" placeholder="e.g. Grace Community Church">
            </div>

            <div class="mb-4">
                <label class="form-label">Church Motto / Slogan</label>
                <input type="text" name="church_motto" value="{{ $settings['church_motto'] ?? 'Grace & Truth for Everyone' }}" class="form-input" placeholder="e.g. Loving God, Loving People">
            </div>

            <div class="mb-4">
                <label class="form-label">Logo URL</label>
                <input type="text" name="church_logo" value="{{ $settings['church_logo'] ?? '' }}" class="form-input" placeholder="https://example.com/logo.png">
                <p class="text-xs mt-1" style="color:var(--text-muted)">Public URL to the church logo</p>
            </div>
        </div>

        {{-- Contact Section --}}
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold)">Contact Details</h3>
            
            <div class="mb-4">
                <label class="form-label">Office Address</label>
                <textarea name="church_address" class="form-input" rows="2">{{ $settings['church_address'] ?? '' }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Phone Number</label>
                <input type="text" name="church_phone" value="{{ $settings['church_phone'] ?? '' }}" class="form-input">
            </div>

            <div class="mb-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="church_email" value="{{ $settings['church_email'] ?? '' }}" class="form-input">
            </div>
        </div>

        {{-- Social Media --}}
        <div class="card p-6 lg:col-span-2">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold)">Social Media Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="form-label">Facebook Page URL</label>
                    <input type="text" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="form-input">
                </div>
                <div class="mb-4">
                    <label class="form-label">Instagram URL</label>
                    <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="form-input">
                </div>
                <div class="mb-4">
                    <label class="form-label">YouTube Channel</label>
                    <input type="text" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" class="form-input">
                </div>
                <div class="mb-4">
                    <label class="form-label">Twitter/X URL</label>
                    <input type="text" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" class="form-input">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-end gap-3">
        <button type="reset" class="btn btn-ghost">Discard Changes</button>
        <button type="submit" class="btn btn-gold px-8">Save All Settings</button>
    </div>
</form>
@endsection
