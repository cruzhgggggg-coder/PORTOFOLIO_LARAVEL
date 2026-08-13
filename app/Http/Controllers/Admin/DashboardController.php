<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Message;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Project stats (1 consolidated query instead of 4)
        $projectStats = Project::selectRaw('
            count(*) as total,
            sum(case when is_featured = 1 then 1 else 0 end) as featured,
            coalesce(sum(views_count), 0) as views,
            coalesce(sum(likes_count), 0) as likes
        ')->first();

        // Message stats (1 consolidated query instead of 4)
        $messageStats = Message::selectRaw('
            count(*) as total,
            sum(case when is_read = 0 then 1 else 0 end) as unread,
            sum(case when created_at >= ? then 1 else 0 end) as last7,
            sum(case when created_at between ? and ? then 1 else 0 end) as prev7
        ', [now()->subDays(7), now()->subDays(14), now()->subDays(7)])->first();

        $recentMessages = Message::latest()->take(5)->get();
        $messageTrend = $messageStats->prev7 > 0
            ? round((($messageStats->last7 - $messageStats->prev7) / $messageStats->prev7) * 100, 1)
            : 0;

        // Content stats (3 queries instead of 5)
        $approvedTestimonials = Testimonial::approved()->count();
        $activeSkills = Skill::active()->count();
        $activeExperiences = Experience::active()->count();
        [$totalCertificates, $activeCertificates] = [
            Certificate::count(),
            Certificate::active()->count(),
        ];

        // Recent projects (2 queries)
        $latestProjects = Project::latest()->take(5)->get();
        $mostViewedProjects = Project::mostViewed(5)->get();

        // Profile & Site Status (uses runtime cache, no DB query)
        $profileName = ProfileSetting::get('name', 'Admin');
        $maintenanceMode = SiteSetting::get('maintenance_mode', false);

        return view('admin.dashboard', [
            'totalProjects' => $projectStats->total,
            'featuredCount' => $projectStats->featured,
            'totalViews' => $projectStats->views,
            'totalLikes' => $projectStats->likes,
            'unreadMessages' => $messageStats->unread,
            'totalMessages' => $messageStats->total,
            'recentMessages' => $recentMessages,
            'messagesLast7Days' => $messageStats->last7,
            'messageTrend' => $messageTrend,
            'approvedTestimonials' => $approvedTestimonials,
            'activeSkills' => $activeSkills,
            'activeExperiences' => $activeExperiences,
            'totalCertificates' => $totalCertificates,
            'activeCertificates' => $activeCertificates,
            'latestProjects' => $latestProjects,
            'mostViewedProjects' => $mostViewedProjects,
            'profileName' => $profileName,
            'maintenanceMode' => $maintenanceMode,
        ]);
    }

    /**
     * Clear all portfolio caches.
     */
    public function clearCache()
    {
        $keys = [
            'portfolio.home_data_v4',
            'portfolio.about_data_v3',
            'portfolio.contact_profile_v3',
            'portfolio.settings_v3',
            'portfolio.settings_profile_v3',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear paginated project caches (pages 1-20)
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("portfolio.projects_page_v3_{$i}");
        }

        // Clear old cache keys (backward compatibility)
        Cache::forget('portfolio.home_data');
        Cache::forget('portfolio.about_data');
        Cache::forget('portfolio.contact_profile');
        Cache::forget('portfolio.settings');
        Cache::forget('portfolio.settings_profile');

        // Refresh settings cache in runtime
        SiteSetting::setRuntimeCache(SiteSetting::allAsArray());

        return back()->with('success', 'All caches cleared successfully! Pages will reload fresh data.');
    }
}
