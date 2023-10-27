<?php

use App\Http\Controllers\ContinentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TakeController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\TermSettingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('quizzes', QuizController::class);
    Route::resource('takes', TakeController::class);

    Route::get('/demo', [DemoController::class, 'index'])->name('demo');

    Route::resource('continents', ContinentController::class);
    Route::resource('countries', CountryController::class);

    Route::resource('taxonomies', TaxonomyController::class);
    Route::resource('settings', SettingController::class);

    Route::resource('terms', TermSettingController::class);
});
