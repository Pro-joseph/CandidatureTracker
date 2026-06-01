<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('candidatures', CandidatureController::class);
    Route::match(['get', 'patch'], 'candidatures/{candidature}/archive', [CandidatureController::class, 'archive'])->name('candidatures.archive');
    Route::post('candidatures/{id}/restore', [CandidatureController::class, 'restore'])->name('candidatures.restore');
    Route::delete('candidatures/{id}/force-delete', [CandidatureController::class, 'forceDelete'])->name('candidatures.force-delete');
    Route::get('archives', [CandidatureController::class, 'archives'])->name('archives.index');

    Route::post('candidatures/{candidature}/entretiens', [EntretienController::class, 'store'])->name('entretiens.store');
    Route::put('entretiens/{entretien}', [EntretienController::class, 'update'])->name('entretiens.update');
    Route::delete('entretiens/{entretien}', [EntretienController::class, 'destroy'])->name('entretiens.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
