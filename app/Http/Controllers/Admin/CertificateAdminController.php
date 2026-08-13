<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'featured') {
                $query->featured();
            }
        }

        $certificates = $query->ordered()->paginate(15);

        return view('admin.certificates.index', [
            'certificates' => $certificates,
        ]);
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request, ImageOptimizer $optimizer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'image_url' => 'nullable|image|max:10240',
            'credential_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $this->handleImageUpload($request->file('image_url'), $optimizer);
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $request->input('sort_order', 0);

        Certificate::create($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate created successfully.');
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', [
            'certificate' => $certificate,
        ]);
    }

    public function update(Request $request, Certificate $certificate, ImageOptimizer $optimizer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'image_url' => 'nullable|image|max:10240',
            'credential_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old image
            if ($certificate->image_url) {
                Storage::disk('public')->delete($certificate->image_url);
            }
            $validated['image_url'] = $this->handleImageUpload($request->file('image_url'), $optimizer);
        } else {
            unset($validated['image_url']);
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', true);

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate updated successfully.');
    }

    public function toggleFeatured(Certificate $certificate)
    {
        $certificate->update(['is_featured' => ! $certificate->is_featured]);

        return back()->with('success', 'Certificate featured status updated.');
    }

    public function destroy(Certificate $certificate)
    {
        // Delete image if exists
        if ($certificate->image_url) {
            Storage::disk('public')->delete($certificate->image_url);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }

    private function handleImageUpload($file, ImageOptimizer $optimizer): string
    {
        $storedPath = $file->store('certificates', 'public');
        
        try {
            return $optimizer->optimizeCertificateImage($storedPath);
        } catch (\Exception $e) {
            // Fallback to original stored path if optimization fails
            return $storedPath;
        }
    }
}
