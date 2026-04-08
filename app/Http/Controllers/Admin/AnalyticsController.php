<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', '30'); // days
        
        // Project analytics
        $totalProjects = Project::count();
        $totalViews = Project::sum('views_count');
        $totalLikes = Project::sum('likes_count');
        $avgViewsPerProject = $totalProjects > 0 ? round($totalViews / $totalProjects, 1) : 0;
        $avgLikesPerProject = $totalProjects > 0 ? round($totalLikes / $totalProjects, 1) : 0;
        
        // Top performing projects
        $topViewedProjects = Project::mostViewed(10)->get();
        $topLikedProjects = Project::mostLiked(10)->get();
        
        // Message analytics
        $totalMessages = Message::count();
        $unreadMessages = Message::unread()->count();
        $repliedMessages = Message::whereNotNull('replied_at')->count();
        $replyRate = $totalMessages > 0 ? round(($repliedMessages / $totalMessages) * 100, 1) : 0;
        
        // Messages over time (last N days)
        $messagesOverTime = Message::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Projects by category
        $projectsByCategory = Project::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();
        
        // Featured vs Non-featured
        $featuredCount = Project::featured()->count();
        $nonFeaturedCount = $totalProjects - $featuredCount;
        
        // Tech stack usage
        $techStackUsage = $this->getTechStackUsage();
        
        // Recent activity (last 7 days)
        $recentActivity = [
            'new_projects' => Project::where('created_at', '>=', now()->subDays(7))->count(),
            'new_messages' => Message::where('created_at', '>=', now()->subDays(7))->count(),
            'replied_messages' => Message::where('replied_at', '>=', now()->subDays(7))->count(),
        ];
        
        // Conversion metrics
        $viewsToLikesRatio = $totalViews > 0 ? round(($totalLikes / $totalViews) * 100, 2) : 0;
        
        return view('admin.analytics.index', [
            'period' => $period,
            'totalProjects' => $totalProjects,
            'totalViews' => $totalViews,
            'totalLikes' => $totalLikes,
            'avgViewsPerProject' => $avgViewsPerProject,
            'avgLikesPerProject' => $avgLikesPerProject,
            'topViewedProjects' => $topViewedProjects,
            'topLikedProjects' => $topLikedProjects,
            'totalMessages' => $totalMessages,
            'unreadMessages' => $unreadMessages,
            'repliedMessages' => $repliedMessages,
            'replyRate' => $replyRate,
            'messagesOverTime' => $messagesOverTime,
            'projectsByCategory' => $projectsByCategory,
            'featuredCount' => $featuredCount,
            'nonFeaturedCount' => $nonFeaturedCount,
            'techStackUsage' => $techStackUsage,
            'recentActivity' => $recentActivity,
            'viewsToLikesRatio' => $viewsToLikesRatio,
        ]);
    }
    
    public function trackProjectView(Project $project)
    {
        $project->incrementViews();
        
        return response()->json(['success' => true]);
    }
    
    public function trackProjectLike(Project $project)
    {
        $project->incrementLikes();
        
        return response()->json(['success' => true]);
    }
    
    private function getTechStackUsage(): array
    {
        $allProjects = Project::all();
        $techStack = [];
        
        foreach ($allProjects as $project) {
            if (is_array($project->tech_stack)) {
                foreach ($project->tech_stack as $tech) {
                    $techLower = strtolower(trim($tech));
                    if ($techLower) {
                        $techStack[$techLower] = ($techStack[$techLower] ?? 0) + 1;
                    }
                }
            }
        }
        
        arsort($techStack);
        
        return array_slice($techStack, 0, 15, true);
    }
}
