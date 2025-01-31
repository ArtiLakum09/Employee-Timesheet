<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;

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

Route::prefix('admin')->group(function() {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth:admin');

    Route::get('/admin/reports', [AdminController::class, 'showReports']);
});

Route::prefix('employee')->group(function() {
    Route::get('login', [EmployeeAuthController::class, 'showLoginForm'])->name('employee.login');
    Route::post('login', [EmployeeAuthController::class, 'login']);
    Route::post('logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');
    Route::get('dashboard', [EmployeeAuthController::class, 'dashboard'])->name('employee.dashboard')->middleware('auth:employee');

    Route::post('/clock-in', [EmployeeController::class, 'clockIn'])->name('employee.clock-in')->middleware('auth:employee');
    Route::post('/clock-out', [EmployeeController::class, 'clockOut'])->name('employee.clock-out')->middleware('auth:employee');
    Route::post('/break-start', [EmployeeController::class, 'startBreak'])->name('employee.break-start')->middleware('auth:employee');;
    Route::post('/break-end', [EmployeeController::class, 'endBreak'])->name('employee.break-end')->middleware('auth:employee');;
    
   
});