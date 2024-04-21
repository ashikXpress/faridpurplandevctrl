<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\PlanServiceCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;




Route::get('/dashboard-redirect', [HomeController::class, 'dashboardRedirect'])->name('dashboard_redirect');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    //User
    Route::resource('user', UserController::class);
    Route::get('user-datatable', [UserController::class, 'dataTable'])->name('user.datatable');


    Route::resource('plan-service-category', PlanServiceCategoryController::class);
    Route::get('plan-service-category-datatable', [PlanServiceCategoryController::class, 'dataTable'])->name('plan-service-category.datatable');

    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dark-mode-change', [ProfileController::class, 'darkModeChange'])->name('dark_mode_change');
    Route::post('/profile-edit', [ProfileController::class, 'editPost'])->name('profile.edit_post');
    Route::get('/password-change', [ProfileController::class, 'passwordEdit'])->name('profile.password_change');
    Route::post('/password-change', [ProfileController::class, 'passwordUpdate']);
});


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('dashboard', function () {
        return view('frontend.user.dashboard');
    })->name('user_dashboard');
});



require __DIR__.'/auth.php';
Route::get('/clear', function () {
   // Artisan::call('cache:forget spatie.permission.cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});
