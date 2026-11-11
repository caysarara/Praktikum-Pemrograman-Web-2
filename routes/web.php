<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

// boleh dibuka siapa saja

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/education', 'education')->name('education');

// Portfolio publik: hanya project berstatus published
Route::get('/projects', [PortfolioController::class, 'projects'])->name('portfolio.projects');
Route::get('/projects/{project}', [PortfolioController::class, 'show'])->name('portfolio.projects.show');


// wajib login

Route::prefix('post')->name('post.')->middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class)->only(['index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/post/profile-saya', [ProfileController::class, 'saya'])->name('profile.saya');
});


// wajib login
Route::prefix('post')->middleware(['auth', 'admin'])->group(function () {
    Route::get('projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
    Route::patch('projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::delete('projects/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.force-delete');

    // Gallery project (upload banyak gambar, edit caption, hapus gambar)
    Route::post('projects/{project}/images', [ProjectGalleryController::class, 'store'])->name('projects.images.store');
    Route::put('projects/{project}/images/{image}', [ProjectGalleryController::class, 'update'])->name('projects.images.update');
    Route::delete('projects/{project}/images/{image}', [ProjectGalleryController::class, 'destroy'])->name('projects.images.destroy');

    Route::resource('projects', ProjectController::class);
    Route::resource('skills', SkillController::class)->except('show');
});

require __DIR__.'/auth.php';
