<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\HistoryRecordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'leads');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('leads',  [LeadController::class, 'index'])->name('leads');
    Route::get('link-contact/{leadID}', [ContactController::class, 'create'])->name('contact.create');
    Route::post('link-contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('history', [HistoryRecordController::class, 'index'])->name('history');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
