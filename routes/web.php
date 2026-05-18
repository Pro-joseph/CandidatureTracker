<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('candidatures', CandidatureController::class);
    Route::patch('candidatures/{candidature}/archive', [CandidatureController::class, 'archive'])->name('candidatures.archive');
    Route::get('archives', [CandidatureController::class, 'archives'])->name('archives.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
