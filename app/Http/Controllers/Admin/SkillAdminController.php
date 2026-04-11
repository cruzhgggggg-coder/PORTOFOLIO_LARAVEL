<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Skill::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->category($request->category);
        }

        // Filter by active status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $skills = $query->ordered()->paginate(20);

        return view('admin.skills.index', [
            'skills' => $skills,
        ]);
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:frontend,backend,tools,soft',
            'proficiency' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $request->input('sort_order', 0);

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', [
            'skill' => $skill,
        ]);
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:frontend,backend,tools,soft',
            'proficiency' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function toggleActive(Skill $skill)
    {
        $skill->update(['is_active' => ! $skill->is_active]);

        return back()->with('success', 'Skill status updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skills,id',
        ]);

        $skillIds = $request->skill_ids;

        switch ($request->action) {
            case 'activate':
                Skill::whereIn('id', $skillIds)->update(['is_active' => true]);
                $message = count($skillIds).' skill(s) activated.';
                break;
            case 'deactivate':
                Skill::whereIn('id', $skillIds)->update(['is_active' => false]);
                $message = count($skillIds).' skill(s) deactivated.';
                break;
            case 'delete':
                Skill::whereIn('id', $skillIds)->delete();
                $message = count($skillIds).' skill(s) deleted.';
                break;
        }

        return back()->with('success', $message);
    }
}
