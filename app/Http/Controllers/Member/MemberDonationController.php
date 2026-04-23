<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finance\Donations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MemberDonationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $member = $user->ensureMemberLinked();
        
        if (!$member) {
            return view('member.donations', [
                'donations' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                'totalDonations' => 0,
                'thisMonthDonations' => 0,
                'avgDonation' => 0,
                'donationCount' => 0,
                'monthlyData' => array_fill(0, 12, 0),
                'annualGiven' => 0,
                'annualGoal' => 50000,
                'fundBreakdown' => []
            ]);
        }

        $query = $member->donations();
        
        $donations = $query->orderByDesc('Date')->paginate(10);
        $totalDonations = $query->sum('Amount');
        
        $thisMonthDonations = $member->donations()
                                       ->whereMonth('Date', Carbon::now()->month)
                                       ->whereYear('Date', Carbon::now()->year)
                                       ->sum('Amount');
                                       
        $donationCount = $query->count();
        $avgDonation = $donationCount > 0 ? $totalDonations / $donationCount : 0;
        
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $member->donations()
                                      ->whereMonth('Date', $i)
                                      ->whereYear('Date', Carbon::now()->year)
                                      ->sum('Amount');
        }
        
        $annualGiven = Donations::whereYear('Date', Carbon::now()->year)->sum('Amount');
        $annualGoal = 50000; // Example goal
        
        $fundTotals = Donations::selectRaw('FundCategory, sum(Amount) as amount')
                               ->groupBy('FundCategory')
                               ->get();
                               
        $fundBreakdown = [];
        foreach ($fundTotals as $ft) {
            $cat = strtolower($ft->FundCategory ?? 'other');
            $key = match(true) {
                str_contains($cat, 'tithe')   => 'tithe',
                str_contains($cat, 'offer')   => 'offering',
                str_contains($cat, 'mission') => 'mission',
                str_contains($cat, 'special') => 'special',
                default                       => 'other',
            };
            
            $fundBreakdown[] = [
                'name'   => $ft->FundCategory ?? 'General Fund',
                'key'    => $key,
                'amount' => $ft->amount
            ];
        }

        return view('member.donations', compact(
            'donations', 
            'totalDonations', 
            'thisMonthDonations', 
            'avgDonation', 
            'donationCount',
            'monthlyData',
            'annualGiven',
            'annualGoal',
            'fundBreakdown'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Amount'          => 'required|numeric|min:1',
            'FundCategory'    => 'required|string|max:255',
            'PaymentMethod'   => 'nullable|string|max:255',
            'ReferenceNumber' => 'nullable|string|max:255',
            'is_anonymous'    => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $member = $user->ensureMemberLinked();

        $donation = Donations::create([
            'Amount'          => $request->Amount,
            'FundCategory'    => $request->FundCategory,
            'PaymentMethod'   => $request->PaymentMethod,
            'ReferenceNumber' => $request->ReferenceNumber,
            'Date'            => Carbon::now()->toDateString(),
            'MinistryID'      => null,
        ]);

        $member->donations()->attach($donation->DonationID, [
            'is_anonymous' => $request->boolean('is_anonymous'),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ]);

        return redirect()->route('member.donations')->with('success', 'Your donation has been recorded. Thank you for your generosity!');
    }

    public function receipt(Donations $donation)
    {
        // Ensure the donation belongs to the authenticated member
        $member = Auth::user()->member;
        
        if (!$member || !$member->donations()->where('member_donations.DonationID', $donation->DonationID)->exists()) {
            abort(403, 'Unauthorized access to this receipt.');
        }

        return view('member.receipt', compact('donation', 'member'));
    }
}
