<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\MessageAdminController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use App\Http\Controllers\Admin\SkillAdminController;
use App\Http\Controllers\Admin\ExperienceAdminController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\AnalyticsController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Portfolio Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ProjectController::class, 'home'])->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/about', [ProjectController::class, 'about'])->name('about');
Route::get('/contact', [ProjectController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Hidden Admin Login (replaces /login → /akses-rahasia-admin)
| Register route is intentionally OMITTED (no public registration)
|--------------------------------------------------------------------------
*/

Route::get('/akses-rahasia-admin', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('admin.auth.login');
})->name('admin.login')->middleware('guest');

// Fortify handles POST /login internally — we just alias its route to our custom view
// The POST action still goes to Fortify's AuthenticatedSessionController
Route::post('/akses-rahasia-admin', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest', 'throttle:login'])
    ->name('admin.login.post');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Block /register entirely
Route::get('/register', function () {
    return redirect()->route('home');
});
Route::post('/register', function () {
    abort(403, 'Registration is disabled.');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['App\Http\Middleware\RedirectGuestToHome'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Project CRUD
        Route::resource('projects', ProjectAdminController::class);
        Route::patch('projects/{project}/toggle-featured', [ProjectAdminController::class, 'toggleFeatured'])
            ->name('projects.toggle-featured');

        // Profile Settings
        Route::get('profile', [ProfileAdminController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [ProfileAdminController::class, 'update'])->name('profile.update');

        // Messages/Inbox
        Route::get('messages', [MessageAdminController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageAdminController::class, 'show'])->name('messages.show');
        Route::post('messages/{message}/reply', [MessageAdminController::class, 'reply'])->name('messages.reply');
        Route::patch('messages/{message}/mark-read', [MessageAdminController::class, 'markAsRead'])->name('messages.mark-read');
        Route::patch('messages/{message}/mark-unread', [MessageAdminController::class, 'markAsUnread'])->name('messages.mark-unread');
        Route::delete('messages/{message}', [MessageAdminController::class, 'destroy'])->name('messages.destroy');
        Route::post('messages/bulk-action', [MessageAdminController::class, 'bulkAction'])->name('messages.bulk-action');

        // Testimonials
        Route::resource('testimonials', TestimonialAdminController::class)->except(['show']);
        Route::patch('testimonials/{testimonial}/toggle-featured', [TestimonialAdminController::class, 'toggleFeatured'])
            ->name('testimonials.toggle-featured');
        Route::patch('testimonials/{testimonial}/approve', [TestimonialAdminController::class, 'approve'])
            ->name('testimonials.approve');

        // Skills & Expertise
        Route::resource('skills', SkillAdminController::class)->except(['show']);
        Route::patch('skills/{skill}/toggle-active', [SkillAdminController::class, 'toggleActive'])
            ->name('skills.toggle-active');
        Route::post('skills/bulk-action', [SkillAdminController::class, 'bulkAction'])
            ->name('skills.bulk-action');

        // Experience/Career
        Route::resource('experiences', ExperienceAdminController::class)->except(['show']);
        Route::patch('experiences/{experience}/toggle-active', [ExperienceAdminController::class, 'toggleActive'])
            ->name('experiences.toggle-active');

        // SEO Settings
        Route::get('seo', [SeoSettingController::class, 'index'])->name('seo.index');
        Route::get('seo/{pageKey}', [SeoSettingController::class, 'edit'])->name('seo.edit');
        Route::put('seo/{pageKey}', [SeoSettingController::class, 'update'])->name('seo.update');

        // Site Settings
        Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
        Route::post('settings/toggle-maintenance', [SiteSettingController::class, 'toggleMaintenanceMode'])
            ->name('settings.toggle-maintenance');
        Route::post('settings/optimize-images', [SiteSettingController::class, 'runImageOptimization'])
            ->name('settings.optimize-images');

        // Analytics
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::post('analytics/projects/{project}/track-view', [AnalyticsController::class, 'trackProjectView'])
            ->name('analytics.track-view');
        Route::post('analytics/projects/{project}/track-like', [AnalyticsController::class, 'trackProjectLike'])
            ->name('analytics.track-like');
    });

require __DIR__ . '/settings.php';
