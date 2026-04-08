<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SeoSettingController extends Controller
{
    public function index()
    {
        $seoSettings = SeoSetting::all()->keyBy('page_key');
        
        $pages = [
            'home' => [
                'name' => 'Homepage',
                'route' => '/',
                'seoSetting' => $seoSettings->get('home'),
            ],
            'projects' => [
                'name' => 'Projects Page',
                'route' => '/projects',
                'seoSetting' => $seoSettings->get('projects'),
            ],
            'about' => [
                'name' => 'About Page',
                'route' => '/about',
                'seoSetting' => $seoSettings->get('about'),
            ],
            'contact' => [
                'name' => 'Contact Page',
                'route' => '/contact',
                'seoSetting' => $seoSettings->get('contact'),
            ],
        ];
        
        return view('admin.seo.index', compact('pages'));
    }
    
    public function edit(string $pageKey)
    {
        $seoSetting = SeoSetting::firstOrCreate(
            ['page_key' => $pageKey],
            ['meta_title' => '', 'meta_description' => '']
        );
        
        return view('admin.seo.edit', [
            'seoSetting' => $seoSetting,
            'pageKey' => $pageKey,
        ]);
    }
    
    public function update(Request $request, string $pageKey)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'no_index' => 'boolean',
            'custom_meta' => 'nullable|array',
        ]);
        
        $validated['no_index'] = $request->boolean('no_index', false);
        
        // Parse custom meta if sent as JSON string
        if (is_string($validated['custom_meta'] ?? null)) {
            $validated['custom_meta'] = json_decode($validated['custom_meta'], true);
        }
        
        $seoSetting = SeoSetting::firstOrCreate(['page_key' => $pageKey]);
        $seoSetting->update($validated);
        
        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO settings updated for ' . $pageKey);
    }
}
