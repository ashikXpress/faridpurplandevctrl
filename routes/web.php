<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\PlanServiceOrderController;
use App\Http\Controllers\CommonDashboardController;
use App\Http\Controllers\Frontend\ApplicationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\PlanServiceCategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SupportingDocumentCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\CheckUserLoginStatus;
use App\Http\Middleware\CheckUserRoleBasePermission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;




Route::get('/dashboard', [CommonDashboardController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware(['auth',CheckUserLoginStatus::class]);

Route::middleware(['auth',CheckUserLoginStatus::class,CheckUserRoleBasePermission::class.':1'])
    ->prefix('admin')->group(function () {
    //User
    Route::resource('user', UserController::class);
    Route::get('user-datatable', [UserController::class, 'dataTable'])->name('user.datatable');

    // Area
    Route::resource('area', AreaController::class);
    Route::get('area-datatable', [AreaController::class, 'dataTable'])->name('area.datatable');

    //supporting-document-category
    Route::resource('supporting-document-category', SupportingDocumentCategoryController::class);
    Route::get('supporting-document-category-datatable', [SupportingDocumentCategoryController::class, 'dataTable'])->name('supporting-document-category.datatable');

    //plan-service-category
    Route::resource('plan-service-category', PlanServiceCategoryController::class);
    Route::get('plan-service-category-datatable', [PlanServiceCategoryController::class, 'dataTable'])->name('plan-service-category.datatable');

     //plan-service-category add supporting-document-items
    Route::get('add-plan-service-category-supporting-document-items/{planServiceCategory}', [PlanServiceCategoryController::class, 'addSupportingDocumentItems'])->name('add-plan-service-category-supporting-document-items');
    Route::post('add-plan-service-category-supporting-document-items/{planServiceCategory}', [PlanServiceCategoryController::class, 'addSupportingDocumentItemsPost']);

    Route::get('plan-service/{planServiceCategory}/order/{status}/status', [PlanServiceOrderController::class, 'index'])->name('plan_service_order');
    Route::get('plan-service-order-datatable', [PlanServiceOrderController::class, 'dataTable'])->name('plan_service_order.datatable');
    Route::post('plan_service_application_status_change', [PlanServiceOrderController::class, 'planServiceApplicationStatusChange'])->name('plan_service_application_status_change');

        //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/dark-mode-change', [ProfileController::class, 'darkModeChange'])->name('dark_mode_change');
    Route::post('/profile-edit', [ProfileController::class, 'editPost'])->name('profile.edit_post');
    Route::get('/password-change', [ProfileController::class, 'passwordEdit'])->name('profile.password_change');
    Route::post('/password-change', [ProfileController::class, 'passwordUpdate']);
});


Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware(['auth',CheckUserLoginStatus::class,CheckUserRoleBasePermission::class.':3'])
    ->prefix('user')->group(function () {
        Route::get('plan-service-application-form/{planServiceCategory}',[ApplicationController::class, 'planServiceApplicationForm'])->name('plan_service_application_form');
        Route::post('plan-service-application-form/{planServiceCategory}',[ApplicationController::class, 'planServiceApplicationFormSubmit']);
        Route::get('/get_areas',[ApplicationController::class, 'getAreas'])->name('get_areas');

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
