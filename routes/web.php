<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SocialLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// FRONTEND ROUTES (Public - Tanpa Login)
// ============================================

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/contact', [FrontendController::class, 'submitContact'])->name('contact.submit');

// ============================================
// AUTH ROUTES (Login/Logout)
// ============================================

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// ADMIN ROUTES (Protected - Butuh Login)
// ============================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Skills Management
    Route::prefix('skills')->name('skills.')->group(function () {
        Route::get('/', [SkillController::class, 'index'])->name('index');
        Route::post('/', [SkillController::class, 'store'])->name('store');
        Route::get('/{id}', [SkillController::class, 'show'])->name('show');
        Route::put('/{id}', [SkillController::class, 'update'])->name('update');
        Route::delete('/{id}', [SkillController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [SkillController::class, 'restore'])->name('restore');
    });
    
    // Portfolios Management
    Route::prefix('portfolios')->name('portfolios.')->group(function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        Route::post('/', [PortfolioController::class, 'store'])->name('store');
        Route::get('/{id}', [PortfolioController::class, 'show'])->name('show');
        Route::put('/{id}', [PortfolioController::class, 'update'])->name('update');
        Route::delete('/{id}', [PortfolioController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [PortfolioController::class, 'restore'])->name('restore');
    });
    
    // Experiences Management
    Route::prefix('experiences')->name('experiences.')->group(function () {
        Route::get('/', [ExperienceController::class, 'index'])->name('index');
        Route::post('/', [ExperienceController::class, 'store'])->name('store');
        Route::get('/{id}', [ExperienceController::class, 'show'])->name('show');
        Route::put('/{id}', [ExperienceController::class, 'update'])->name('update');
        Route::delete('/{id}', [ExperienceController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [ExperienceController::class, 'restore'])->name('restore');
    });
    
    // Educations Management
    Route::prefix('educations')->name('educations.')->group(function () {
        Route::get('/', [EducationController::class, 'index'])->name('index');
        Route::post('/', [EducationController::class, 'store'])->name('store');
        Route::get('/{id}', [EducationController::class, 'show'])->name('show');
        Route::put('/{id}', [EducationController::class, 'update'])->name('update');
        Route::delete('/{id}', [EducationController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [EducationController::class, 'restore'])->name('restore');
    });
    
    // Testimonials Management
    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('index');
        Route::post('/', [TestimonialController::class, 'store'])->name('store');
        Route::get('/{id}', [TestimonialController::class, 'show'])->name('show');
        Route::put('/{id}', [TestimonialController::class, 'update'])->name('update');
        Route::delete('/{id}', [TestimonialController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [TestimonialController::class, 'restore'])->name('restore');
    });
    
    // Social Links Management
    Route::prefix('social-links')->name('social-links.')->group(function () {
        Route::get('/', [SocialLinkController::class, 'index'])->name('index');
        Route::post('/', [SocialLinkController::class, 'store'])->name('store');
        Route::get('/{id}', [SocialLinkController::class, 'show'])->name('show');
        Route::put('/{id}', [SocialLinkController::class, 'update'])->name('update');
        Route::delete('/{id}', [SocialLinkController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [SocialLinkController::class, 'restore'])->name('restore');
    });
    
});

require __DIR__.'/auth.php';
