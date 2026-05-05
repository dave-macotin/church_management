@extends('admin.layout.app')
@section('title', 'Volunteer Management — ' . App\Models\Setting::get('church_name', 'Grace Church'))

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Create Opportunity --}}
    <div class="col-span-1">
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold)">Create Opportunity</h3>
            <form method="POST" action="{{ route('admin.volunteering.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g., Sunday Choir">
                </div>
                <div class="mb-4">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-input">
                        <option value="Media">Media & Tech</option>
                        <option value="Greeting">Greeting & Ushering</option>
                        <option value="Music">Music & Worship</option>
                        <option value="Children">Children's Ministry</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Time Slot</label>
                        <input type="text" name="time_slot" class="form-input" placeholder="8:00 AM">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Volunteers Needed</label>
                    <input type="number" name="needed_volunteers" class="form-input" value="1" min="1">
                </div>
                <div class="mb-6">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-gold w-full tracking-widest uppercase text-[10px] font-bold">Launch Opportunity</button>
            </form>
        </div>
    </div>

    {{-- Opportunities List --}}
    <div class="col-span-1 xl:col-span-2">
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-white/5 flex justify-between items-center bg-black/10">
                <h3 class="font-cinzel text-sm uppercase tracking-widest text-gold">Active Opportunities</h3>
            </div>
            
            <table class="w-full">
                <thead>
                    <tr class="bg-black/20 text-[10px] uppercase tracking-widest text-muted">
                        <th class="p-4 text-left">Opportunity</th>
                        <th class="p-4 text-left">Date/Time</th>
                        <th class="p-4 text-center">Needed</th>
                        <th class="p-4 text-center">Registrations</th>
                        <th class="p-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opp)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-sm">{{ $opp->title }}</div>
                                <div class="text-[10px] text-muted">{{ $opp->category }}</div>
                            </td>
                            <td class="p-4 text-xs">
                                {{ $opp->date ? \Carbon\Carbon::parse($opp->date)->format('M d, Y') : 'Ongoing' }}<br>
                                <span class="text-gold opacity-70">{{ $opp->time_slot }}</span>
                            </td>
                            <td class="p-4 text-center text-sm font-cinzel">{{ $opp->needed_volunteers }}</td>
                            <td class="p-4 text-center">
                                <span class="badge {{ $opp->registrations_count > 0 ? 'badge-amber' : 'badge-muted' }}">
                                    {{ $opp->registrations_count }} signed up
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <span class="badge {{ $opp->is_active ? 'badge-green' : 'badge-red' }}">
                                    {{ $opp->is_active ? 'Active' : 'Closed' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-muted text-sm">No opportunities created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-white/5">
                {{ $opportunities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
