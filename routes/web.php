<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminDashboardController,
    Controller,
    CertificationController,
    CraftsmanController,
    DistributionController,
    FactoryController,
    HarvestController,
    MonitoringController,
    WasteManagementController,
    RoleController,
    Auth\RegisterController,
    Auth\LoginController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController

};

Route::get('/home', function () {
    return view('admin.page.dashboard');
})->middleware('auth');


// Route::get('/', [adminDashboardController::class, 'dashboard'])->name('dashboard');
// Route::get('/dashboard', [adminDashboardController::class, 'dashboard'])->name('dashboard');
// Route::get('/monitoring', [Controller::class, 'monitoring'])->name('monitoring');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::middleware(['auth', 'harvest'])->group(function () {
    Route::prefix('harvest')->group(function () {
        Route::get('/', [HarvestController::class, 'index'])->name('harvest.index');
        Route::get('/create', [HarvestController::class, 'create'])->name('harvest.create');
        Route::post('/', [HarvestController::class, 'store'])->name('harvest.store');
        Route::get('/{id}', [HarvestController::class, 'show'])->name('harvest.show');
        Route::get('/{id}/edit', [HarvestController::class, 'edit'])->name('harvest.edit');
        Route::put('/{id}', [HarvestController::class, 'update'])->name('harvest.update');
        Route::delete('/{id}', [HarvestController::class, 'destroy'])->name('harvest.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('certification')->group(function () {
        Route::get('/', [CertificationController::class, 'index'])->name('certification.index');
        Route::get('/create', [CertificationController::class, 'create'])->name('certification.create');
        Route::post('/', [CertificationController::class, 'store'])->name('certification.store');
        Route::get('/{id}', [CertificationController::class, 'show'])->name('certification.show');
        Route::get('/{id}/edit', [CertificationController::class, 'edit'])->name('certification.edit');
        Route::put('/{id}', [CertificationController::class, 'update'])->name('certification.update');
        Route::delete('/{id}', [CertificationController::class, 'destroy'])->name('certification.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('craftsman')->group(function () {
        Route::get('/', [CraftsmanController::class, 'index'])->name('craftsman.index');
        Route::get('/create', [CraftsmanController::class, 'create'])->name('craftsman.create');
        Route::post('/', [CraftsmanController::class, 'store'])->name('craftsman.store');
        Route::get('/{id}', [CraftsmanController::class, 'show'])->name('craftsman.show');
        Route::get('/{id}/edit', [CraftsmanController::class, 'edit'])->name('craftsman.edit');
        Route::put('/{id}', [CraftsmanController::class, 'update'])->name('craftsman.update');
        Route::delete('/{id}', [CraftsmanController::class, 'destroy'])->name('craftsman.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('distribution')->group(function () {
        Route::get('/', [DistributionController::class, 'index'])->name('distribution.index');
        Route::get('/create', [DistributionController::class, 'create'])->name('distribution.create');
        Route::post('/', [DistributionController::class, 'store'])->name('distribution.store');
        Route::get('/{id}', [DistributionController::class, 'show'])->name('distribution.show');
        Route::get('/{id}/edit', [DistributionController::class, 'edit'])->name('distribution.edit');
        Route::put('/{id}', [DistributionController::class, 'update'])->name('distribution.update');
        Route::delete('/{id}', [DistributionController::class, 'destroy'])->name('distribution.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('factory')->group(function () {
        Route::get('/', [FactoryController::class, 'index'])->name('factory.index');
        Route::get('/create', [FactoryController::class, 'create'])->name('factory.create');
        Route::post('/', [FactoryController::class, 'store'])->name('factory.store');
        Route::get('/{id}', [FactoryController::class, 'show'])->name('factory.show');
        Route::get('/{id}/edit', [FactoryController::class, 'edit'])->name('factory.edit');
        Route::put('/{id}', [FactoryController::class, 'update'])->name('factory.update');
        Route::delete('/{id}', [FactoryController::class, 'destroy'])->name('factory.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('monitoring')->group(function () {
        Route::get('/', [MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('/create', [MonitoringController::class, 'create'])->name('monitoring.create');
        Route::post('/', [MonitoringController::class, 'store'])->name('monitoring.store');
        Route::get('/{id}', [MonitoringController::class, 'show'])->name('monitoring.show');
        Route::get('/{id}/edit', [MonitoringController::class, 'edit'])->name('monitoring.edit');
        Route::put('/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
        Route::delete('/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('waste-management')->group(function () {
        Route::get('/', [WasteManagementController::class, 'index'])->name('waste-management.index');
        Route::get('/create', [WasteManagementController::class, 'create'])->name('waste-management.create');
        Route::post('/', [WasteManagementController::class, 'store'])->name('waste-management.store');
        Route::get('/{id}', [WasteManagementController::class, 'show'])->name('waste-management.show');
        Route::get('/{id}/edit', [WasteManagementController::class, 'edit'])->name('waste-management.edit');
        Route::put('/{id}', [WasteManagementController::class, 'update'])->name('waste-management.update');
        Route::delete('/{id}', [WasteManagementController::class, 'destroy'])->name('waste-management.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/select', [RoleController::class, 'select'])->name('roles.select');
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/{id}', [RoleController::class, 'show'])->name('role.show');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });
});