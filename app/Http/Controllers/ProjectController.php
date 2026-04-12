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

class ProjectController extends Controller
{
    public function home()
    {
        $data = cache()->remember('portfolio.home_data', 86400, function () {
            return [
                'projects' => Project::featured()->latest()->get(),
                'profile' => ProfileSetting::allAsArray(),
                'testimonials' => Testimonial::approved()->featured()->ordered()->take(6)->get(),
            ];
        });

        return view('home', $data);
    }

    public function index()
    {
        $page = request()->input('page', 1);
        $perPage = SiteSetting::get('projects_per_page', 9);

        $projects = cache()->remember("portfolio.projects_page_{$page}", 86400, function () use ($perPage) {
            return Project::latest()->paginate($perPage);
        });

        return view('projects', [
            'projects' => $projects,
        ]);
    }

    public function about()
    {
        $data = cache()->remember('portfolio.about_data', 86400, function () {
            $skills = Skill::active()->ordered()->get()->groupBy('category');

            return [
                'profile' => ProfileSetting::allAsArray(),
                'skills' => $skills,
                'experiences' => Experience::active()->ordered()->get(),
                'testimonials' => Testimonial::approved()->ordered()->take(6)->get(),
            ];
        });

        return view('about', $data);
    }

    public function contact()
    {
        $profile = cache()->remember('portfolio.contact_profile', 86400, function () {
            return ProfileSetting::allAsArray();
        });

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
