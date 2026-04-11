<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');
        
        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'auto_optimize_images' => 'nullable|boolean',
        ]);
        
        // Define which keys are booleans to ensure they are handled correctly when unchecked
        $booleanKeys = [
            'maintenance_mode', 
            'auto_optimize_images'
        ];

        // Combine validated data with boolean checks (for unchecked boxes)
        $data = $validated;
        foreach ($booleanKeys as $key) {
            $data[$key] = $request->boolean($key);
        }
        
        // Update each setting
        foreach ($data as $key => $value) {
            $type = in_array($key, $booleanKeys) ? 'boolean' : 'text';
            SiteSetting::set($key, $value, $type);
        }
        
        return back()->with('success', 'Site settings updated successfully.');
    }
    
    public function toggleMaintenanceMode()
    {
        $current = SiteSetting::isMaintenanceMode();
        SiteSetting::set('maintenance_mode', !$current, 'boolean');
        
        return back()->with('success', 
            $current ? 'Maintenance mode disabled.' : 'Maintenance mode enabled.'
        );
    }

    public function runImageOptimization(\App\Services\ImageOptimizer $optimizer)
    {
        try {
            $results = $optimizer->optimizeAllExisting();
            
            // Also update database references (matching what the Artisan command does)
            $updated = 0;
            // Profile photos
            $profilePhotos = \App\Models\ProfileSetting::where('key', 'photo_url')->get();
            foreach ($profilePhotos as $setting) {
                if ($setting->value && !str_ends_with(parse_url($setting->value, PHP_URL_PATH), '.webp')) {
                    $setting->value = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $setting->value);
                    $setting->save();
                    $updated++;
                }
            }
            // Project images
            $projects = \App\Models\Project::whereNotNull('image_url')->get();
            foreach ($projects as $project) {
                if ($project->image_url && str_starts_with($project->image_url, '/storage/') && !str_ends_with(parse_url($project->image_url, PHP_URL_PATH), '.webp')) {
                    $project->image_url = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $project->image_url);
                    $project->save();
                    $updated++;
                }
            }

            $total = $results['profile'] + $results['projects'];
            return back()->with('success', "Optimization complete! $total images processed. $updated database references updated.");
        } catch (\Exception $e) {
            return back()->with('error', 'Optimization failed: ' . $e->getMessage());
        }
    }
}
