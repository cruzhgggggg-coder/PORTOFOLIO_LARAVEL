<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProfileSetting;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Testimonial;

class ProjectController extends Controller
{
    public function home()
    {
        return view('home', [
            'projects'      => Project::featured()->latest()->get(),
            'profile'       => ProfileSetting::allAsArray(),
            'testimonials'  => Testimonial::approved()->featured()->ordered()->take(6)->get(),
        ]);
    }

    public function index()
    {
        return view('projects', [
            'projects' => Project::latest()->get(),
        ]);
    }

    public function about()
    {
        $skills = Skill::active()->ordered()->get()->groupBy('category');

        return view('about', [
            'profile'     => ProfileSetting::allAsArray(),
            'skills'      => $skills,
            'experiences' => Experience::active()->ordered()->get(),
            'testimonials'=> Testimonial::approved()->ordered()->take(6)->get(),
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'profile' => ProfileSetting::allAsArray(),
        ]);
    }
}

