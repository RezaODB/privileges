<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrochureController;

// FRONT
Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/theory', [PageController::class, 'theory'])->name('theory');
Route::get('/info', [PageController::class, 'info'])->name('info');
Route::get('/stats', [PageController::class, 'stats'])->name('stats');
Route::get('/id', [PageController::class, 'id'])->name('id');
Route::get('/quota', [PageController::class, 'quotas'])->name('quota');
Route::get('/brochure', [PageController::class, 'brochure'])->name('brochure');
Route::get('/vote', [PageController::class, 'vote'])->name('vote');

// BACK
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('/users', [UserController::class, 'index'])->middleware('auth')->name('users.index');
Route::resource('brochures', BrochureController::class)->except('show')->middleware('auth');
Route::resource('quotas', QuotaController::class)->except('show')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
