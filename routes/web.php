<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/theory', [PageController::class, 'theory'])->name('theory');
Route::get('/info', [PageController::class, 'info'])->name('info');
Route::get('/stats', [PageController::class, 'stats'])->name('stats');
Route::get('/id', [PageController::class, 'id'])->name('id');
Route::get('/quotas', [PageController::class, 'quotas'])->name('quotas');
Route::get('/brochure', [PageController::class, 'brochure'])->name('brochure');
Route::get('/vote', [PageController::class, 'vote'])->name('vote');

Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
