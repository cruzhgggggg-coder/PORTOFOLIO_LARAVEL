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
            'maintenance_mode' => 'boolean',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:100',
            'facebook_pixel_id' => 'nullable|string|max:100',
            'show_tech_marquee' => 'boolean',
            'show_features_section' => 'boolean',
            'projects_per_page' => 'integer|min:1|max:50',
            'enable_testimonials' => 'boolean',
            'enable_analytics' => 'boolean',
            'brand_color_primary' => 'nullable|string|max:20',
            'brand_color_secondary' => 'nullable|string|max:20',
        ]);
        
        // Update each setting
        foreach ($validated as $key => $value) {
            $type = in_array($key, ['maintenance_mode', 'show_tech_marquee', 'show_features_section', 'enable_testimonials', 'enable_analytics']) 
                ? 'boolean' 
                : (in_array($key, ['projects_per_page']) ? 'integer' : 'text');
            
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
}
