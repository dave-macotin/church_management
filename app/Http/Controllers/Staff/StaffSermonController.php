<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Sermon;
use Illuminate\Http\Request;

class StaffSermonController extends Controller
{
    public function index()
    {
        $sermons = Sermon::with('submittedBy')->latest('preached_at')->paginate(20);
        return view('staff.sermons.index', compact('sermons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'preacher'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'preached_at' => 'required|date',
            'video_url'   => 'nullable|url',
            'series'      => 'nullable|string|max:255',
        ]);

        $data['is_approved']  = false;
        $data['submitted_by'] = auth()->id();

        Sermon::create($data);

        return redirect()->route('staff.sermons.index')
                         ->with('success', 'Sermon submitted for admin approval.');
    }
}
