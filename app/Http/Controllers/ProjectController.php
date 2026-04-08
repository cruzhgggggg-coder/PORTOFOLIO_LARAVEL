<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProfileSetting;

class ProjectController extends Controller
{
    public function home()
    {
        return view('home', [
            'projects'  => Project::featured()->latest()->get(),
            'profile'   => ProfileSetting::allAsArray(),
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
        return view('about', [
            'profile' => ProfileSetting::allAsArray(),
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'profile' => ProfileSetting::allAsArray(),
        ]);
    }
}
