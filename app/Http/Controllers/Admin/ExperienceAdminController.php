<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExperienceAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Experience::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->type($request->type);
        }

        // Filter by active status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'current') {
                $query->current();
            }
        }

        $experiences = $query->ordered()->paginate(15);

        return view('admin.experiences.index', [
            'experiences' => $experiences,
        ]);
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:work,education,certification',
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'highlights' => 'nullable|string',
            'logo_url' => 'nullable|image|max:2048',
            'link' => 'nullable|url|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo_url')) {
            $validated['logo_url'] = $this->handleLogoUpload($request->file('logo_url'));
        }

        $validated['is_current'] = $request->boolean('is_current', false);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $request->input('sort_order', 0);

        // Parse highlights from textarea string to array
        if ($request->filled('highlights')) {
            $validated['highlights'] = array_values(array_filter(array_map('trim', explode("\n", $request->highlights))));
        } else {
            $validated['highlights'] = [];
        }

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience created successfully.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', [
            'experience' => $experience,
        ]);
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'type' => 'required|in:work,education,certification',
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'highlights' => 'nullable|string',
            'logo_url' => 'nullable|image|max:2048',
            'link' => 'nullable|url|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        // Handle boolean values precisely
        $validated['is_current'] = $request->boolean('is_current');
        $validated['is_active'] = $request->boolean('is_active');

        // If currently active, end date must be null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        // Handle logo upload
        if ($request->hasFile('logo_url')) {
            if ($experience->logo_url) {
                Storage::disk('public')->delete($experience->logo_url);
            }
            $validated['logo_url'] = $this->handleLogoUpload($request->file('logo_url'));
        } else {
            // Keep existing logo if not replaced, but ensure we don't overwrite with null from validator
            unset($validated['logo_url']);
        }

        // Parse highlights from textarea string to array
        if ($request->filled('highlights')) {
            $validated['highlights'] = array_values(array_filter(array_map('trim', explode("\n", $request->highlights))));
        } else {
            $validated['highlights'] = [];
        }

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience updated successfully.');
    }

    public function toggleActive(Experience $experience)
    {
        $experience->update(['is_active' => ! $experience->is_active]);

        return back()->with('success', 'Experience status updated.');
    }

    public function destroy(Experience $experience)
    {
        if ($experience->logo_url) {
            Storage::disk('public')->delete($experience->logo_url);
        }

        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience deleted successfully.');
    }

    private function handleLogoUpload($file): string
    {
        $path = $file->store('experiences/logos', 'public');

        return $path;
    }
}
