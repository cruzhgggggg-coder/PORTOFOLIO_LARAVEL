<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProfileSetting;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProjects'   => Project::count(),
            'featuredCount'   => Project::featured()->count(),
            'latestProjects'  => Project::latest()->take(5)->get(),
            'profileName'     => ProfileSetting::get('name', 'Admin'),
        ]);
    }
}
