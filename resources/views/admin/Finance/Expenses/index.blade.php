@extends('admin.layout.app')

@section('title', 'Expenses')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-cinzel text-xl font-semibold" style="color:var(--gold)">Expenses</h1>
        <p class="text-sm mt-0.5" style="color:var(--text-muted)">Track church expenditures</p>
    </div>
    <a href="{{ route('admin.expenses.create') }}" class="btn btn-gold">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Expense
    </a>
</div>

{{-- Stat --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6 flex items-center gap-5 border-l-4 border-l-gold-bright">
        <div class="w-12 h-12 rounded-xl bg-gold-bright/10 flex items-center justify-center text-gold-bright">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:24px;height:24px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125-1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
        </div>
        <div>
            <div class="text-[10px] font-bold text-gold-muted uppercase tracking-wider mb-1">Total Expenses</div>
            <div class="font-cinzel text-2xl font-bold text-gold-bright">₱{{ number_format($total, 2) }}</div>
        </div>
    </div>
</div>

<form method="GET" action="{{ route('admin.expenses.index') }}" class="mb-6">
    <div class="search-wrap" style="max-width:400px">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
        <input type="text" name="search" class="form-input" placeholder="Search category or vendor…"
               value="{{ request('search') }}">
    </div>
</form>

<div class="card overflow-hidden">
    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Vendor</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td style="color:var(--gold-muted)">#{{ $expense->ExpenseID }}</td>
                        <td><span class="badge badge-muted">{{ $expense->Category ?? 'Uncategorized' }}</span></td>
                        <td><span class="text-cream font-medium">{{ $expense->Vendor ?? '—' }}</span></td>
                        <td><span class="font-bold text-gold-bright">₱{{ number_format($expense->Amount, 2) }}</span></td>
                        <td style="color:var(--gold-muted)">
                            {{ $expense->created_at ? $expense->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn btn-ghost btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.expenses.destroy', $expense) }}"
                                      method="POST" onsubmit="return confirm('Delete this expense?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                                </svg>
                                <h4>No Expenses Found</h4>
                                <p>You haven't recorded any church expenditures yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($expenses->hasPages())
    <div class="flex gap-1 mt-4 pagination">
        {{ $expenses->links() }}
    </div>
@endif

@endsection
