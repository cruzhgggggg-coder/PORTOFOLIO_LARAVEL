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
                $settings = Cache::remember('portfolio.settings', 86400, function () {
                    return SiteSetting::allAsArray();
                });
            }
            if (Schema::hasTable('profile_settings')) {
                $profile = Cache::remember('portfolio.settings_profile', 86400, function () {
                    return ProfileSetting::allAsArray();
                });
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
