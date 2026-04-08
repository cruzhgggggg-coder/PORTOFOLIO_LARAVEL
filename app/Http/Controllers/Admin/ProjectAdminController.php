<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectAdminController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', [
            'projects' => Project::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'tech_stack'  => 'nullable|string',
            'tags'        => 'nullable|string',
            'year'        => 'required|string|max:4',
            'link_repo'   => 'nullable|url|max:500',
            'link_demo'   => 'nullable|url|max:500',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $imageUrl = Storage::url($path);
        }

        // Process tech_stack and tags from comma-separated to array
        $techStack = null;
        if (!empty($validated['tech_stack'])) {
            $techStack = array_map('trim', explode(',', $validated['tech_stack']));
        }

        $tags = null;
        if (!empty($validated['tags'])) {
            $tags = array_map('trim', explode(',', $validated['tags']));
        }

        Project::create([
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']),
            'category'    => $validated['category'],
            'description' => $validated['description'],
            'image_url'   => $imageUrl,
            'tech_stack'  => $techStack,
            'tags'        => $tags,
            'year'        => $validated['year'],
            'link_repo'   => $validated['link_repo'] ?? null,
            'link_demo'   => $validated['link_demo'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'tech_stack'  => 'nullable|string',
            'tags'        => 'nullable|string',
            'year'        => 'required|string|max:4',
            'link_repo'   => 'nullable|url|max:500',
            'link_demo'   => 'nullable|url|max:500',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle new image upload
        $imageUrl = $project->image_url;
        if ($request->hasFile('image')) {
            // Delete old image if it's in storage
            if ($project->image_url && str_starts_with($project->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $project->image_url);
                Storage::delete($oldPath);
            }
            $path = $request->file('image')->store('projects', 'public');
            $imageUrl = Storage::url($path);
        }

        // Process tech_stack and tags
        $techStack = $project->tech_stack;
        if (isset($validated['tech_stack'])) {
            $techStack = !empty($validated['tech_stack'])
                ? array_map('trim', explode(',', $validated['tech_stack']))
                : null;
        }

        $tags = $project->tags;
        if (isset($validated['tags'])) {
            $tags = !empty($validated['tags'])
                ? array_map('trim', explode(',', $validated['tags']))
                : null;
        }

        $project->update([
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']),
            'category'    => $validated['category'],
            'description' => $validated['description'],
            'image_url'   => $imageUrl,
            'tech_stack'  => $techStack,
            'tags'        => $tags,
            'year'        => $validated['year'],
            'link_repo'   => $validated['link_repo'] ?? null,
            'link_demo'   => $validated['link_demo'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        // Delete associated image if stored locally
        if ($project->image_url && str_starts_with($project->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', 'public/', $project->image_url);
            Storage::delete($oldPath);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil dihapus!');
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);

        return back()->with('success', 'Status featured berhasil diubah!');
    }
}
