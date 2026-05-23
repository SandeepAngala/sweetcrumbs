<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->paginate(20);

        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
        ]);

        TeamMember::create([
            'name' => $data['name'],
            'role' => $data['role'],
            'bio' => $data['bio'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'image' => $request->hasFile('image') ? $images->storeImage($request->file('image'), 'team') : null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team, ImageUploadService $images)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
        ]);

        $payload = [
            'name' => $data['name'],
            'role' => $data['role'],
            'bio' => $data['bio'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $payload['image'] = $images->storeImage($request->file('image'), 'team');
        }

        $team->update($payload);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();

        return back()->with('success', 'Team member removed.');
    }
}
