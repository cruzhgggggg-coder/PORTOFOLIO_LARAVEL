<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();
        
        // Filter by approval status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->approved();
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'featured') {
                $query->featured();
            }
        }
        
        $testimonials = $query->ordered()->paginate(15);
        
        return view('admin.testimonials.index', [
            'testimonials' => $testimonials,
        ]);
    }
    
    public function create()
    {
        return view('admin.testimonials.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'avatar_url' => 'nullable|image|max:2048',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'project_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'sort_order' => 'integer',
        ]);
        
        // Handle avatar upload
        if ($request->hasFile('avatar_url')) {
            $validated['avatar_url'] = $this->handleAvatarUpload($request->file('avatar_url'));
        }
        
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_approved'] = $request->boolean('is_approved', true);
        $validated['sort_order'] = $request->input('sort_order', 0);
        
        Testimonial::create($validated);
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }
    
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', [
            'testimonial' => $testimonial,
        ]);
    }
    
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'avatar_url' => 'nullable|image|max:2048',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'project_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'sort_order' => 'integer',
        ]);
        
        // Handle avatar upload
        if ($request->hasFile('avatar_url')) {
            // Delete old avatar
            if ($testimonial->avatar_url) {
                Storage::disk('public')->delete($testimonial->avatar_url);
            }
            $validated['avatar_url'] = $this->handleAvatarUpload($request->file('avatar_url'));
        }
        
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_approved'] = $request->boolean('is_approved', true);
        
        $testimonial->update($validated);
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }
    
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);
        
        return back()->with('success', 'Testimonial featured status updated.');
    }
    
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);
        
        return back()->with('success', 'Testimonial approved.');
    }
    
    public function destroy(Testimonial $testimonial)
    {
        // Delete avatar if exists
        if ($testimonial->avatar_url) {
            Storage::disk('public')->delete($testimonial->avatar_url);
        }
        
        $testimonial->delete();
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
    
    private function handleAvatarUpload($file): string
    {
        $cloudinary = app(\App\Services\CloudinaryService::class);
        $cloudUrl = $cloudinary->upload($file, 'testimonials');
        
        if ($cloudUrl) {
            return $cloudUrl;
        }

        $path = $file->store('testimonials/avatars', 'public');
        return Storage::url($path);
    }
}
