<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Message;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        // Core stats
        $totalProjects = Project::count();
        $featuredCount = Project::featured()->count();
        $totalViews = Project::sum('views_count');
        $totalLikes = Project::sum('likes_count');

        // Messages stats
        $unreadMessages = Message::unread()->count();
        $totalMessages = Message::count();
        $recentMessages = Message::latest()->take(5)->get();

        // Content stats
        $approvedTestimonials = Testimonial::approved()->count();
        $activeSkills = Skill::active()->count();
        $activeExperiences = Experience::active()->count();

        // Recent projects
        $latestProjects = Project::latest()->take(5)->get();

        // Most viewed projects
        $mostViewedProjects = Project::mostViewed(5)->get();

        // Profile
        $profileName = ProfileSetting::get('name', 'Admin');

        // Site Status
        $maintenanceMode = SiteSetting::isMaintenanceMode();

        // Quick analytics - last 7 days messages
        $messagesLast7Days = Message::where('created_at', '>=', now()->subDays(7))->count();
        $messagesPrevious7Days = Message::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $messageTrend = $messagesPrevious7Days > 0
            ? round((($messagesLast7Days - $messagesPrevious7Days) / $messagesPrevious7Days) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'totalProjects',
            'featuredCount',
            'totalViews',
            'totalLikes',
            'unreadMessages',
            'totalMessages',
            'recentMessages',
            'approvedTestimonials',
            'activeSkills',
            'activeExperiences',
            'latestProjects',
            'mostViewedProjects',
            'profileName',
            'messagesLast7Days',
            'messageTrend',
            'maintenanceMode'
        ));
    }
}
