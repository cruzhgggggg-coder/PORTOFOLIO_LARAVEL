<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Message;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function home()
    {
        $cachedData = Cache::get('portfolio.home_data_v3');
        
        if ($cachedData) {
            $data = json_decode($cachedData, true);
            // Convert arrays back to objects for the views
            $data['projects'] = collect($data['projects'])->map(fn($item) => (object) $item);
            $data['testimonials'] = collect($data['testimonials'])->map(fn($item) => (object) $item);
        } else {
            $data = [
                'projects' => Project::featured()->latest()->get()->toArray(),
                'profile' => ProfileSetting::allAsArray(),
                'testimonials' => Testimonial::approved()->featured()->ordered()->take(6)->get()->toArray(),
            ];
            Cache::put('portfolio.home_data_v3', json_encode($data), 86400);
            
            // Convert to objects for immediate view use
            $data['projects'] = collect($data['projects'])->map(fn($item) => (object) $item);
            $data['testimonials'] = collect($data['testimonials'])->map(fn($item) => (object) $item);
        }

        return view('home', $data);
    }

    public function index()
    {
        $page = request()->input('page', 1);
        $perPage = SiteSetting::get('projects_per_page', 9);
        $cacheKey = "portfolio.projects_page_v3_{$page}";

        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            $data = json_decode($cachedData, true);
            $projects = new \Illuminate\Pagination\LengthAwarePaginator(
                collect($data['items'])->map(fn($item) => (object) $item),
                $data['total'],
                $data['per_page'],
                $data['current_page'],
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            $projects = Project::latest()->paginate($perPage);
            $cacheData = [
                'items' => $projects->items(),
                'total' => $projects->total(),
                'per_page' => $projects->perPage(),
                'current_page' => $projects->currentPage(),
            ];
            Cache::put($cacheKey, json_encode($cacheData), 86400);
        }

        return view('projects', [
            'projects' => $projects,
        ]);
    }

    public function about()
    {
        $cachedData = Cache::get('portfolio.about_data_v3');
        
        if ($cachedData) {
            $data = json_decode($cachedData, true);
            // Convert to objects/collections for the view
            $data['skills'] = collect($data['skills'])->map(fn($group) => collect($group)->map(fn($item) => (object) $item));
            $data['experiences'] = collect($data['experiences'])->map(fn($item) => (object) $item);
            $data['testimonials'] = collect($data['testimonials'])->map(fn($item) => (object) $item);
        } else {
            $data = [
                'profile' => ProfileSetting::allAsArray(),
                'skills' => Skill::active()->ordered()->get()->groupBy('category')->toArray(),
                'experiences' => Experience::active()->ordered()->get()->toArray(),
                'testimonials' => Testimonial::approved()->ordered()->take(6)->get()->toArray(),
            ];
            Cache::put('portfolio.about_data_v3', json_encode($data), 86400);
            
            // Convert for immediate use
            $data['skills'] = collect($data['skills'])->map(fn($group) => collect($group)->map(fn($item) => (object) $item));
            $data['experiences'] = collect($data['experiences'])->map(fn($item) => (object) $item);
            $data['testimonials'] = collect($data['testimonials'])->map(fn($item) => (object) $item);
        }

        return view('about', $data);
    }

    public function contact()
    {
        $cachedData = Cache::get('portfolio.contact_profile_v3');
        
        if ($cachedData) {
            $profile = json_decode($cachedData, true);
        } else {
            $profile = ProfileSetting::allAsArray();
            Cache::put('portfolio.contact_profile_v3', json_encode($profile), 86400);
        }

        return view('contact', [
            'profile' => $profile,
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Message::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transmission received successfully.',
        ]);
    }
}
