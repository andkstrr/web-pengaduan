<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HeadStaffController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\isNotLogin;
use App\Http\Middleware\isStaff;
use App\Http\Middleware\isHeadStaff;

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

Route::middleware(['isNotLogin'])->group (function() {
    // Landing Page
    Route::get('/', function () {
        return view('welcome');
    });
    // Halaman login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Proses login
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Proses registrasi
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware(['isLogin'])->group (function() {
    // Home Guest
    Route::get('/home', [ReportController::class, 'index'])->name('home');
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Membuat Report
    Route::prefix('reports')->name('reports.')->group(function() {
        // Search
        // Membuat Reports
        Route::get('/create', [ReportController::class, 'showCreateForm'])->name('create');
        Route::post('/store', [ReportController::class, 'store'])->name('store');
        // Information Reports -> Show
        Route::get('/information/', [ReportController::class, 'showAllInformation'])->name('showAll');
        // Comment Report
        Route::get('/comment/{id}', [ReportController::class, 'showDetailComment'])->name('comment');
        Route::post('/comments/{id}', [ReportController::class, 'storeComment'])->name('storeComment');
        // Vote Report
        Route::get('/vote/{id}', [ReportController::class, 'voteReport'])->name('vote');
        Route::delete('/delete/{id}', [ReportController::class, 'deleteReport'])->name('delete');
    });

    Route::prefix('headstaff')->name('headstaff.')->group(function() {
        Route::get('/dashboard', [HeadStaffController::class, 'index'])->name('dashboard');
        Route::post('/account-store', [HeadStaffController::class, 'store'])->name('store');
        Route::delete('/account-delete/{id}', [HeadStaffController::class, 'delete'])->name('delete');
    });
});

Route::get('/search', [ReportController::class, 'search'])->name('search');

Route::middleware(['isStaff'])->group (function() {
    // Home Staff
    Route::prefix('responses')->name('responses.')->group(function() {
        // Melihat Response
        Route::get('/index', [StaffController::class, 'index'])->name('home');
        // Export Excel
        Route::get('/export/all', [StaffController::class, 'exportAll'])->name('export-all');
        // Export by Date
        Route::get('/export/date', [StaffController::class, 'exportByDate'])->name('export-date');
        // Menindaklanjuti Response
        Route::get('/status/{id}', [StaffController::class, 'showStatus'])->name('status');
        // Set Response Status
        Route::get('/setstatus/{id}', [ResponseController::class, 'setStatus'])->name('setstatus');
    });
});

