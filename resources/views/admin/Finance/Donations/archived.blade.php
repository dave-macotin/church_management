@extends('admin.layout.app')

@section('title', 'Archived Donations')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.donations.index') }}" class="btn btn-ghost" style="padding:0.4rem 0.8rem">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Back to Donations
    </a>
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Archived Donations</h1>
        <p class="text-sm" style="color:var(--text-muted)">Soft-deleted donation records — restore if needed</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 p-3 rounded" style="background:rgba(93,202,165,0.15);border:1px solid rgba(93,202,165,0.3);color:#5DCAA5;font-size:0.875rem">
        ✓ {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Donor</th>
                    <th>Fund Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Archived On</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                    <tr>
                        <td style="color:var(--text-muted)">{{ $donation->DonationID }}</td>
                        <td>
                            @if($donation->members->isNotEmpty())
                                @foreach($donation->members as $member)
                                    @if($member->pivot->is_anonymous)
                                        <span style="color:var(--text-muted);font-style:italic">Anonymous</span>
                                    @else
                                        {{ $member->FirstName }} {{ $member->LastName }}
                                    @endif
                                @endforeach
                            @else
                                <span style="color:var(--text-muted);font-style:italic">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $donation->FundCategory ?? '—' }}</td>
                        <td style="color:var(--gold)">₱{{ number_format($donation->Amount, 2) }}</td>
                        <td style="color:var(--text-muted)">
                            {{ $donation->Date ? $donation->Date->format('M d, Y') : '—' }}
                        </td>
                        <td style="color:var(--text-muted);font-size:0.8rem">
                            {{ $donation->deleted_at ? $donation->deleted_at->format('M d, Y') : '—' }}
                        </td>
                        <td style="text-align:right">
                            <form action="{{ route('admin.donations.restore', $donation->DonationID) }}"
                                  method="POST"
                                  onsubmit="return confirm('Restore this donation?')">
                                @csrf
                                <button type="submit" class="btn btn-gold"
                                        style="padding:0.35rem 0.75rem;font-size:0.8rem">
                                    Restore
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--text-muted)">
                            No archived donations.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($donations->hasPages())
    <div class="flex gap-1 mt-4 pagination">
        {{ $donations->links() }}
    </div>
@endif

@endsection
