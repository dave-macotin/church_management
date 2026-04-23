<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Expense;
use App\Models\Ministry\Event;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('event');

        if ($request->filled('search')) {
            $query->where('Category', 'like', '%'.$request->search.'%')
                  ->orWhere('Vendor', 'like', '%'.$request->search.'%');
        }

        $expenses = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $total    = Expense::sum('Amount');

        return view('admin.Finance.Expenses.index', compact('expenses', 'total'));
    }

    public function create()
    {
        $events = Event::where('is_approved', true)->orderByDesc('StartDateTime')->get();
        return view('admin.Finance.Expenses.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Category' => 'nullable|string|max:100',
            'Amount'   => 'required|numeric|min:0',
            'Vendor'   => 'nullable|string|max:150',
            'EventID'  => 'nullable|exists:events,EventID',
        ]);

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')
                         ->with('success', 'Expense recorded successfully.');
    }

    public function edit(Expense $expense)
    {
        $events = Event::where('is_approved', true)->orderByDesc('StartDateTime')->get();
        return view('admin.Finance.Expenses.edit', compact('expense', 'events'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'Category' => 'nullable|string|max:100',
            'Amount'   => 'required|numeric|min:0',
            'Vendor'   => 'nullable|string|max:150',
            'EventID'  => 'nullable|exists:events,EventID',
        ]);

        $expense->update($validated);

        return redirect()->route('admin.expenses.index')
                         ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')
                         ->with('success', 'Expense deleted.');
    }
}