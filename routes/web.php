<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BrochureController;

// FRONT
Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/policy', [PageController::class, 'policy'])->name('policy');
Route::get('/step1', [PageController::class, 'step1'])->name('step1');
Route::get('/step2', [PageController::class, 'step2'])->name('step2');
Route::get('/step3', [PageController::class, 'step3'])->name('step3');
Route::get('/step4', [PageController::class, 'step4'])->name('step4');
Route::get('/step5', [PageController::class, 'step5'])->name('step5');
Route::get('/step6', [PageController::class, 'step6'])->name('step6');

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
