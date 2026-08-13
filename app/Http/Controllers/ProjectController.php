<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function home()
    {
        return view('home', [
            'projects' => Project::featured()->latest()->get(),
            'certificates' => Certificate::active()->featured()->ordered()->take(10)->get(),
        ]);
    }

    public function index(Request $request)
    {
        $perPage = SiteSetting::get('projects_per_page', 9);

        return view('projects', [
            'projects' => Project::latest()->paginate($perPage),
        ]);
    }

    public function about()
    {
        return view('about', [
            'skills' => Skill::active()->ordered()->get()->groupBy('category'),
            'experiences' => Experience::active()->ordered()->get(),
            'funFacts' => Testimonial::funFacts()->active()->ordered()->take(6)->get(),
        ]);
    }

    public function contact()
    {
        return view('contact');
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
