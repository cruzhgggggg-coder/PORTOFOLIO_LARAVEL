<?php

namespace App\Http\Middleware;

use App\Models\SeoSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SeoMetaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()?->getName();

        $pageMap = [
            'home' => 'home',
            'projects' => 'projects',
            'about' => 'about',
            'contact' => 'contact',
        ];

        $pageKey = $pageMap[$routeName] ?? null;

        if ($pageKey) {
            $seo = Cache::remember("portfolio.seo.{$pageKey}", 86400, function () use ($pageKey) {
                return SeoSetting::getByPage($pageKey);
            });

            view()->share('seoMeta', $seo?->meta_tags ?? []);
        } else {
            view()->share('seoMeta', []);
        }

        return $next($request);
    }
}
