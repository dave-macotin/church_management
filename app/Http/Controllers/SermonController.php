<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sermon;
use Illuminate\Support\Facades\Storage;

class SermonController extends Controller
{
    // Member view — only approved sermons
    public function index()
    {
        $layout  = $this->layoutFor(auth()->user()->role);
        $sermons = Sermon::where('is_approved', true)->latest('preached_at')->paginate(12);
        return view('sermons.index', compact('sermons', 'layout'));
    }

    public function show(Sermon $sermon)
    {
        $role = auth()->user()->role;
        $layout = $this->layoutFor($role);
        
        $backUrl = match($role) {
            'admin' => route('admin.sermons.index'),
            'staff' => route('staff.sermons.index'),
            default => route('sermons.index'),
        };

        return view('sermons.show', compact('sermon', 'layout', 'backUrl'));
    }

    // Admin — all sermons with approval management
    public function adminIndex()
    {
        $sermons = Sermon::with('submittedBy')->latest('preached_at')->paginate(20);
        return view('admin.Ministry.Sermons.index', compact('sermons'));
    }

    // Admin add sermon (auto-approved)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'preacher'      => 'required|string|max:255',
            'description'   => 'nullable|string',
            'preached_at'   => 'required|date',
            'video_url'     => 'nullable|url',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'series'        => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('thumbnail_url')) {
            $data['thumbnail_url'] = $request->file('thumbnail_url')->store('sermons', 'public');
        }

        $data['is_approved']  = auth()->user()->role === 'admin';
        $data['submitted_by'] = auth()->id();

        Sermon::create($data);

        return back()->with('success', 'Sermon added to library!');
    }

    // Admin approve a sermon
    public function approve(Sermon $sermon)
    {
        $sermon->update(['is_approved' => true]);
        return back()->with('success', "Sermon '{$sermon->title}' approved.");
    }

    // Staff submit a sermon for approval
    public function staffStore(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'preacher'      => 'required|string|max:255',
            'description'   => 'nullable|string',
            'preached_at'   => 'required|date',
            'video_url'     => 'nullable|url',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'series'        => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('thumbnail_url')) {
            $data['thumbnail_url'] = $request->file('thumbnail_url')->store('sermons', 'public');
        }

        $data['is_approved']  = false;
        $data['submitted_by'] = auth()->id();

        Sermon::create($data);

        return back()->with('success', 'Sermon submitted for admin approval.');
    }

    private function layoutFor(string $role): string
    {
        return match($role) {
            'admin' => 'admin.Layout.app',
            'staff' => 'admin.Layout.app',
            default => 'member.layout.app',
        };
    }
}
