<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\ProfileAdminController;
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
})->name('login')->middleware('guest');

// Fortify handles POST /login internally — we just alias its route to our custom view
// The POST action still goes to Fortify's AuthenticatedSessionController
Route::post('/akses-rahasia-admin', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest', 'throttle:login'])
    ->name('admin.login.post');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Redirect /login to our hidden admin login page (so nothing breaks)
Route::redirect('/login', '/akses-rahasia-admin')->name('login.redirect');

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
    });

require __DIR__.'/settings.php';
