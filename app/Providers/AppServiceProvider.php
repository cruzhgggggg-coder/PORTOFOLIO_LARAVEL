<?php

namespace App\Providers;

use App\Models\ProfileSetting;
use App\Models\SiteSetting;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        // Register Observers for Cache Invalidation
        \App\Models\Project::observe(\App\Observers\PortfolioObserver::class);
        \App\Models\ProfileSetting::observe(\App\Observers\PortfolioObserver::class);
        \App\Models\Testimonial::observe(\App\Observers\PortfolioObserver::class);
        \App\Models\Skill::observe(\App\Observers\PortfolioObserver::class);
        \App\Models\Experience::observe(\App\Observers\PortfolioObserver::class);
        \App\Models\SiteSetting::observe(\App\Observers\PortfolioObserver::class);

        // Share site settings globally with all views
        $settings = [];
        $profile = [];
        
        if (! app()->runningInConsole()) {
            if (Schema::hasTable('site_settings')) {
                $cachedSettings = Cache::get('portfolio.settings_v3');
                if ($cachedSettings) {
                    $settings = json_decode($cachedSettings, true);
                } else {
                    $settings = SiteSetting::allAsArray();
                    Cache::put('portfolio.settings_v3', json_encode($settings), 86400);
                }
            }
            if (Schema::hasTable('profile_settings')) {
                $cachedProfile = Cache::get('portfolio.settings_profile_v3');
                if ($cachedProfile) {
                    $profile = json_decode($cachedProfile, true);
                } else {
                    $profile = ProfileSetting::allAsArray();
                    Cache::put('portfolio.settings_profile_v3', json_encode($profile), 86400);
                }
            }
        }
        
        View::share('siteSettings', $settings);
        View::share('profile', $profile);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
