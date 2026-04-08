<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSetting;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileAdminController extends Controller
{
    public function edit()
    {
        $settings = ProfileSetting::allAsArray();

        return view('admin.profile.edit', compact('settings'));
    }

    public function update(Request $request, ImageOptimizer $optimizer)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'tagline'     => 'nullable|string|max:200',
            'bio'         => 'nullable|string',
            'location'    => 'nullable|string|max:100',
            'email'       => 'nullable|email|max:150',
            'github_url'  => 'nullable|url|max:300',
            'twitter_url' => 'nullable|url|max:300',
            'linkedin_url' => 'nullable|url|max:300',
            'years_exp'   => 'nullable|integer|min:0',
            'projects_count' => 'nullable|integer|min:0',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'hero_badge'  => 'nullable|string|max:100',
            'hero_line1'  => 'nullable|string|max:200',
            'hero_line2'  => 'nullable|string|max:200',
            'hero_desc'   => 'nullable|string|max:500',
            'phone'       => 'nullable|string|max:50',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            $oldPhoto = ProfileSetting::get('photo_url');
            if ($oldPhoto) {
                // Determine the path relative to the storage disk
                $pathPart = parse_url($oldPhoto, PHP_URL_PATH);
                if ($pathPart && str_starts_with($pathPart, '/storage/')) {
                    $oldPath = str_replace('/storage/', 'public/', $pathPart);
                    Storage::delete($oldPath);

                    // Also delete WebP version if exists
                    $webpPath = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $oldPath);
                    if ($webpPath !== $oldPath) {
                        Storage::delete($webpPath);
                    }
                }
            }

            // Store original file temporarily
            $path = $request->file('photo')->store('profile', 'public');

            // Optimize the image (converts to WebP)
            $optimizedPath = $optimizer->optimizeProfilePhoto($path);

            // Store the optimized URL
            ProfileSetting::set('photo_url', Storage::url($optimizedPath));
        }

        // Save all text settings
        $keys = [
            'name',
            'tagline',
            'bio',
            'location',
            'email',
            'phone',
            'github_url',
            'twitter_url',
            'linkedin_url',
            'years_exp',
            'projects_count',
            'hero_badge',
            'hero_line1',
            'hero_line2',
            'hero_desc',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                ProfileSetting::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
