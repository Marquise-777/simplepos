<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetupController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth',
    'verified',
    'setup.completed'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/setup/business', [SetupController::class, 'business'])
        ->name('setup.business');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('setup')->name('setup.')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/business', [SetupController::class, 'business'])
        ->name('business');

    Route::post('/business', [SetupController::class, 'storeBusiness'])
        ->name('business.store');

    Route::get('/invoice', [SetupController::class, 'invoice'])
        ->name('invoice');

    Route::post('/invoice', [SetupController::class, 'storeInvoice'])
        ->name('invoice.store');

    Route::get('/complete', [SetupController::class, 'complete'])
        ->name('complete');
    Route::post('/finish', [SetupController::class, 'finish'])
        ->name('finish');
});


require __DIR__ . '/auth.php';
