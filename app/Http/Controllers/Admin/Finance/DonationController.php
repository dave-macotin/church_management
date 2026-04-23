<?php
namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Donations;
use App\Models\People\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donations::with('members');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('FundCategory', 'like', '%'.$request->search.'%')
                  ->orWhereHas('members', function ($m) use ($request) {
                      $m->where('FirstName', 'like', '%'.$request->search.'%')
                        ->orWhere('LastName',  'like', '%'.$request->search.'%');
                  });
            });
        }

        $donations = $query->orderByDesc('Date')->paginate(15)->withQueryString();
        $total     = Donations::sum('Amount');

        return view('admin.Finance.Donations.index', compact('donations', 'total'));
    }

    public function create()
    {
        $members = Member::orderBy('LastName')->orderBy('FirstName')->get();
        return view('admin.Finance.Donations.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MemberID'     => 'required|exists:members,MemberID',
            'Amount'       => 'required|numeric|min:1',
            'Date'         => 'required|date',
            'FundCategory' => 'required|string|max:100',
        ]);

        $donation = Donations::create([
            'Amount'       => $validated['Amount'],
            'Date'         => $validated['Date'],
            'FundCategory' => $validated['FundCategory'],
        ]);

        // Link to member via pivot table
        DB::table('member_donations')->insert([
            'MemberID'   => $validated['MemberID'],
            'DonationID' => $donation->DonationID,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation recorded successfully.');
    }

    // Archive (soft delete) — no hard delete
    public function destroy(Donations $donation)
    {
        $donation->delete(); // soft delete via SoftDeletes trait
        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation archived successfully.');
    }

    // Restore archived donation
    public function restore($id)
    {
        Donations::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation restored.');
    }

    // View archived donations
    public function archived()
    {
        $donations = Donations::onlyTrashed()->with('members')->orderByDesc('deleted_at')->paginate(15);
        return view('admin.Finance.Donations.archived', compact('donations'));
    }
}