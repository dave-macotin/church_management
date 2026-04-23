@extends('member.layout.app')
@section('title', 'Child Management — ' . App\Models\Setting::get('church_name', 'Grace Church'))
@section('page_title', 'Child Check-In')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Register Child Form --}}
    <div class="col-span-1">
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold-mid)">Register Child</h3>
            <form method="POST" action="{{ route('member.children.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">First Name</label>
                    <input type="text" name="FirstName" class="form-input" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="LastName" class="form-input" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Birth Date</label>
                    <input type="date" name="BirthDate" class="form-input" required>
                </div>
                <div class="mb-6">
                    <label class="form-label">Medical Notes / Allergies</label>
                    <textarea name="MedicalNotes" class="form-input" rows="3" placeholder="Any important medical info..."></textarea>
                </div>
                <button type="submit" class="btn btn-gold w-full">Register Child</button>
            </form>
        </div>
    </div>

    {{-- My Children List --}}
    <div class="col-span-1 lg:col-span-2">
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-6" style="color:var(--gold-mid)">My Registered Children</h3>
            
            @if($children->isEmpty())
                <div class="text-center py-12">
                    <div class="text-4xl mb-4 opacity-20">👶</div>
                    <p style="color:var(--gold-muted)">No children registered yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($children as $child)
                        <div class="p-4 rounded-lg bg-white/5 border border-white/10">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="font-bold text-lg">{{ $child->FirstName }} {{ $child->LastName }}</div>
                                    <div class="text-xs" style="color:var(--gold-muted)">Age: {{ \Carbon\Carbon::parse($child->BirthDate)->age }} years</div>
                                </div>
                                <div class="text-center bg-accent/20 border border-accent/40 rounded px-3 py-1">
                                    <div class="text-[8px] uppercase font-bold text-accent">Pickup Code</div>
                                    <div class="text-lg font-cinzel font-bold tracking-widest text-white">{{ $child->PickupCode }}</div>
                                </div>
                            </div>
                            
                            @if($child->MedicalNotes)
                                <div class="mt-2 p-2 rounded bg-red-900/20 border border-red-900/40">
                                    <div class="text-[9px] uppercase font-bold text-red-400">Medical Notes</div>
                                    <div class="text-xs text-red-200">{{ $child->MedicalNotes }}</div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 p-4 rounded-lg bg-blue-900/20 border border-blue-900/40 flex gap-4 items-center">
                    <div class="text-2xl">💡</div>
                    <div class="text-xs" style="color:var(--blue)">
                        <strong>Important Safety Note:</strong> Please present the unique 6-digit pickup code to the staff at the check-in desk when checking your child in or out.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
