@extends('staff.layout.app')
@section('title', 'Volunteer Management — Grace Church Staff')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Create Opportunity --}}
    <div class="col-span-1">
        <div class="card p-6">
            <h3 class="font-cinzel text-lg mb-4" style="color:var(--gold-mid)">Submit Opportunity</h3>
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-500/10 border border-green-500/20 text-green-500 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('staff.volunteering.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Title *</label>
                        <input type="text" name="title" class="form-input mt-1" required placeholder="e.g., Sunday Choir">
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Category</label>
                        <select name="category" class="form-input mt-1">
                            <option value="Media">Media & Tech</option>
                            <option value="Greeting">Greeting & Ushering</option>
                            <option value="Music">Music & Worship</option>
                            <option value="Children">Children's Ministry</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Date</label>
                            <input type="date" name="date" class="form-input mt-1">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Time Slot</label>
                            <input type="text" name="time_slot" class="form-input mt-1" placeholder="8:00 AM">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Volunteers Needed</label>
                        <input type="number" name="needed_volunteers" class="form-input mt-1" value="1" min="1">
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-tighter" style="color:var(--gold-muted)">Description *</label>
                        <textarea name="description" class="form-input mt-1" rows="4" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-gold w-full mt-6 py-3">Submit for Admin Approval</button>
            </form>
        </div>
    </div>

    {{-- Opportunities List --}}
    <div class="col-span-1 xl:col-span-2">
        <div class="card overflow-hidden">
            <div class="panel-header">
                <h3 class="panel-title">Your/Active Opportunities</h3>
            </div>
            
            <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--bg-panel); color:var(--gold-mid); font-size:11px; text-transform:uppercase;">
                        <th class="p-4">Opportunity</th>
                        <th class="p-4">Date/Time</th>
                        <th class="p-4 text-center">Needed</th>
                        <th class="p-4 text-center">Registrations</th>
                        <th class="p-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($opportunities as $opp)
                        <tr>
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
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(250,199,117,0.12); color:#FAC775;">
                                    {{ $opp->registrations_count }} signed up
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                @if(!$opp->is_approved)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(250,199,117,0.12); color:#FAC775;">Pending</span>
                                @elseif($opp->is_active)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(93,202,165,0.12); color:#5DCAA5;">Active</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase" style="background:rgba(216,90,48,0.12); color:#D85A30;">Closed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-muted text-sm">No opportunities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $opportunities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
