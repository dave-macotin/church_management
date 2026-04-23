<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People\Member;
use App\Models\People\Family;
use App\Models\Ministry\Event;
use App\Models\People\Group;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = $request->get('query');
        $results = [];

        if (!$query) return response()->json([]);

        // Search Members
        $members = Member::where('FirstName', 'LIKE', "%{$query}%")
            ->orWhere('LastName', 'LIKE', "%{$query}%")
            ->orWhere('Email', 'LIKE', "%{$query}%")
            ->limit(5)->get();

        foreach ($members as $m) {
            $results[] = [
                'title' => "{$m->FirstName} {$m->LastName}",
                'type'  => 'Member',
                'url'   => route('admin.members.show', $m->MemberID)
            ];
        }

        // Search Events
        $events = Event::where('Title', 'LIKE', "%{$query}%")
            ->orWhere('Location', 'LIKE', "%{$query}%")
            ->limit(5)->get();

        foreach ($events as $e) {
            $results[] = [
                'title' => $e->Title,
                'type'  => 'Event',
                'url'   => route('admin.events.show', $e->EventID)
            ];
        }

        // Search Families
        $families = Family::where('FamilyName', 'LIKE', "%{$query}%")
            ->limit(3)->get();

        foreach ($families as $f) {
            $results[] = [
                'title' => "Family: {$f->FamilyName}",
                'type'  => 'Family',
                'url'   => route('admin.families.show', $f->FamilyID)
            ];
        }

        // Search Groups
        $groups = Group::where('GroupName', 'LIKE', "%{$query}%")
            ->limit(3)->get();

        foreach ($groups as $g) {
            $results[] = [
                'title' => $g->GroupName,
                'type'  => 'Group',
                'url'   => route('admin.groups.show', $g->GroupID)
            ];
        }

        return response()->json($results);
    }
}
