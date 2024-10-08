<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
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
    HomeController,
    UserController,
    AdminController,
    NFTController,
    BatikController
};

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('/select', [RoleController::class, 'select'])->name('roles.select');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    });

    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profileIndex'])->name('profile.index');
        Route::get('/profile/edit', [UserController::class, 'profileEdit'])->name('profile.edit');
        Route::put('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');
    });

});

Route::middleware(['auth', 'harvest'])->group(function () {
    Route::prefix('harvest')->group(function () {
        Route::get('/', [HarvestController::class, 'index'])->name('harvest.index');
        Route::get('/create', [HarvestController::class, 'create'])->name('harvest.create');
        Route::post('/', [HarvestController::class, 'store'])->name('harvest.store');
        Route::get('/{id}/edit', [HarvestController::class, 'edit'])->name('harvest.edit');
        Route::put('/{id}', [HarvestController::class, 'update'])->name('harvest.update');
        Route::delete('/{id}', [HarvestController::class, 'destroy'])->name('harvest.destroy');
    });
});

Route::middleware(['auth', 'factory'])->group(function () {
    Route::prefix('factory')->group(function () {
        Route::get('/', [FactoryController::class, 'index'])->name('factory.index');
        Route::get('/create', [FactoryController::class, 'create'])->name('factory.create');
        Route::post('/', [FactoryController::class, 'store'])->name('factory.store');
        Route::get('/{id}/edit', [FactoryController::class, 'edit'])->name('factory.edit');
        Route::put('/{id}', [FactoryController::class, 'update'])->name('factory.update');
        Route::delete('/{id}', [FactoryController::class, 'destroy'])->name('factory.destroy');
    });
});

Route::middleware(['auth', 'craftsman'])->group(function () {
    Route::prefix('craftsman')->group(function () {
        Route::get('/', [CraftsmanController::class, 'index'])->name('craftsman.index');
        Route::get('/create', [CraftsmanController::class, 'create'])->name('craftsman.create');
        Route::get('/ref/{id}', [CraftsmanController::class, 'createfacref'])->name('craftsman.ref.create');
        Route::post('/ref', [CraftsmanController::class, 'storefacref'])->name('craftsman.ref.store');
        Route::post('/', [CraftsmanController::class, 'store'])->name('craftsman.store');
        Route::get('/{id}/edit', [CraftsmanController::class, 'edit'])->name('craftsman.edit');
        Route::put('/{id}', [CraftsmanController::class, 'update'])->name('craftsman.update');
        Route::delete('/{id}', [CraftsmanController::class, 'destroy'])->name('craftsman.destroy');
    });
});

Route::middleware(['auth', 'certification'])->group(function () {
    Route::prefix('certification')->group(function () {
        Route::get('/', [CertificationController::class, 'index'])->name('certification.index');
        Route::get('/create', [CertificationController::class, 'create'])->name('certification.create');
        Route::post('/', [CertificationController::class, 'store'])->name('certification.store');
        Route::get('/{id}/edit', [CertificationController::class, 'edit'])->name('certification.edit');
        Route::put('/{id}', [CertificationController::class, 'update'])->name('certification.update');
        Route::delete('/{id}', [CertificationController::class, 'destroy'])->name('certification.destroy');
    });
});

Route::middleware(['auth', 'waste_management'])->group(function () {
    Route::prefix('waste')->group(function () {
        Route::get('/', [WasteManagementController::class, 'index'])->name('waste.index');
        Route::get('/create', [WasteManagementController::class, 'create'])->name('waste.create');
        Route::post('/', [WasteManagementController::class, 'store'])->name('waste.store');
        Route::get('/{id}/edit', [WasteManagementController::class, 'edit'])->name('waste.edit');
        Route::put('/{id}', [WasteManagementController::class, 'update'])->name('waste.update');
        Route::delete('/{id}', [WasteManagementController::class, 'destroy'])->name('waste.destroy');
    });
});

Route::middleware(['auth', 'distribution'])->group(function () {
    Route::prefix('distribution')->group(function () {
        Route::get('/', [DistributionController::class, 'index'])->name('distribution.index');
        Route::get('/create', [DistributionController::class, 'create'])->name('distribution.create');
        Route::post('/', [DistributionController::class, 'store'])->name('distribution.store');
        Route::get('/{id}/edit', [DistributionController::class, 'edit'])->name('distribution.edit');
        Route::put('/{id}', [DistributionController::class, 'update'])->name('distribution.update');
        Route::delete('/{id}', [DistributionController::class, 'destroy'])->name('distribution.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('monitoring')->group(function () {
        Route::get('/{id}', [MonitoringController::class, 'show'])->name('monitoring.show');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    });

    Route::prefix('nft')->group(function () {
        Route::get('/edit', [NFTController::class, 'editNFTConfig'])->name('edit-nft');
        Route::put('/update', [NFTController::class, 'updateNFTConfig'])->name('update-nft');
        Route::get('/verify/{transactionHash}', [NFTController::class, 'verifyNFT'])->name('verify-nft');
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/unauthorized', [HomeController::class, 'unauthorized'])->name('unauthorized');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('password')->group(function () {
    Route::get('forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.forgot.form');
    Route::post('forgot', [ForgotPasswordController::class, 'sendResetLink'])->name('password.forgot.email');
    
    Route::get('reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');
});

Route::prefix('show')->group(function () {
    Route::get('/harvests/{id}', [HarvestController::class, 'show'])->name('harvests.show');
    Route::get('/factory/{id}', [FactoryController::class, 'show'])->name('factory.show');
    Route::get('/craftsman/{id}', [CraftsmanController::class, 'show'])->name('craftsman.show');
    Route::get('/certification/{id}', [CertificationController::class, 'show'])->name('certification.show');
    Route::get('/waste-management/{id}', [WasteManagementController::class, 'show'])->name('waste-management.show');
    Route::get('/distribution/{id}', [DistributionController::class, 'show'])->name('distribution.show');
    Route::get('/certificate/{id}', [CertificationController::class, 'generateCertificate'])->name('certificate');
    Route::get('/batik/{id}', [BatikController::class, 'show'])->name('batik.show');
});

