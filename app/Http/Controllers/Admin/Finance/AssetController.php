<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Assets;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Assets::query();

        if ($request->filled('search')) {
            $query->where('ItemName', 'like', '%'.$request->search.'%')
                  ->orWhere('SerialNumber', 'like', '%'.$request->search.'%');
        }

        $assets     = $query->orderBy('ItemName')->paginate(15)->withQueryString();
        $totalValue = Assets::sum('Value');

        return view('admin.Finance.Assets.index', compact('assets', 'totalValue'));
    }

    public function create()
    {
        return view('admin.Finance.Assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ItemName'     => 'required|string|max:150',
            'SerialNumber' => 'nullable|string|max:100',
            'PurchaseDate' => 'nullable|date',
            'Value'        => 'nullable|numeric|min:0',
            'Notes'        => 'nullable|string',
        ]);

        Assets::create($validated);

        return redirect()->route('admin.assets.index')
                         ->with('success', 'Asset added successfully.');
    }

    public function edit(Assets $asset)
    {
        return view('admin.Finance.Assets.edit', compact('asset'));
    }

    public function update(Request $request, Assets $asset)
    {
        $validated = $request->validate([
            'ItemName'     => 'required|string|max:150',
            'SerialNumber' => 'nullable|string|max:100',
            'PurchaseDate' => 'nullable|date',
            'Value'        => 'nullable|numeric|min:0',
            'Notes'        => 'nullable|string',
        ]);

        $asset->update($validated);

        return redirect()->route('admin.assets.index')
                         ->with('success', 'Asset updated successfully.');
    }

    public function destroy(Assets $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')
                         ->with('success', 'Asset deleted.');
    }
}
