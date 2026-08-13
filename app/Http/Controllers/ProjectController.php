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

    public function sitemap()
    {
        $pages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => url('/projects'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => url('/about'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/contact'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$page['url']}</loc>\n";
            $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
