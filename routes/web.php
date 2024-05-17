<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SampleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::get('login', [SampleController::class, 'index'])->name('login');
Route::get('registration', [SampleController::class, 'registration'])->name('registration');
Route::get('logout', [SampleController::class, 'logout'])->name('logout');
Route::post('validate_registration', [SampleController::class, 'validate_registration'])->name('sample.validate_registration');
Route::post('validate_login', [SampleController::class, 'validate_login'])->name('sample.validate_login');
Route::get('dashboard', [SampleController::class, 'dashboard'])->name('dashboard');

// Admin route
Route::get('/admin/adminpage', [SampleController::class, 'adminPage'])->middleware('admin')->name('adminpage');

