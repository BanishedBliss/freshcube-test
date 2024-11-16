<?php

use App\Http\Controllers\DealController;
use App\Http\Controllers\HistoryRecordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', 'deals');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('deals',  [DealController::class, 'index'])->name('deals');
    Route::get('history', [HistoryRecordController::class, 'index'])->name('history');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
