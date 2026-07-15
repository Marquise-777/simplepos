<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Setup Wizard
|--------------------------------------------------------------------------
*/

Route::prefix('setup')
    ->name('setup.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

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

/*
|--------------------------------------------------------------------------
| SIMPOS Application
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
    'setup.completed',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Sales
    |--------------------------------------------------------------------------
    */

    // New Sale
    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    // Sales History
    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/{sale}', [SaleController::class, 'show'])
        ->name('sales.show');

    Route::get('/sales/{sale}/print', [SaleController::class, 'print'])
        ->name('sales.print');

    Route::post('/sales/{sale}/cancel', [SaleController::class, 'cancel'])
        ->name('sales.cancel');

    Route::post('/sales/{sale}/refund', [SaleController::class, 'refund'])
        ->name('sales.refund');


    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    Route::prefix('customers')
        ->name('customers.')
        ->group(function () {

            Route::get('/', [CustomerController::class, 'index'])
                ->name('index');

            Route::post('/create', [CustomerController::class, 'create'])
                ->name('create');
        });


    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')
        ->name('reports.')
        ->group(function () {

            Route::get('/', [ReportController::class, 'index'])
                ->name('index');

            Route::get('/sales', [ReportController::class, 'sales'])
                ->name('sales');

            Route::get('/payments', [ReportController::class, 'payments'])
                ->name('payments');

            Route::get('/daily', [ReportController::class, 'daily'])
                ->name('daily');

            Route::get('/monthly', [ReportController::class, 'monthly'])
                ->name('monthly');
        });


    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::prefix('settings')
        ->name('settings.')
        ->group(function () {

            Route::get('/', [SettingController::class, 'index'])
                ->name('index');

            Route::post('/', [SettingController::class, 'update'])
                ->name('update');
        });
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
