<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Quickcount\QuickcountController;
use App\Http\Controllers\Relawan\RelawanController;
use App\Http\Controllers\Util\IndonesiaAreaController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)
    ->name('auth.')
    ->prefix('/auth')
    ->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'loginPost')->name('loginPost');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'registerPost')->name('registerPost');
    });

Route::prefix('utility')
    ->name('utility.')
    ->group(function () {
        Route::controller(IndonesiaAreaController::class)
            ->prefix('area')
            ->name('area.')
            ->group(function () {
                Route::get('/province', 'province')->name('province');
                Route::get('/city', 'city')->name('city');
                Route::get('/district', 'district')->name('district');
                Route::get('/sub-district', 'subDistrict')->name('sub-district');
                Route::get('/tps', 'getTps')->name('tps');
            });
    });

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::middleware(['checkRole:0'])->group(function () {
            Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            // relawan
            Route::get('/admin/relawan', [AdminController::class, 'index'])->name('admin.index');
            // search relawan
            Route::get('/search-relawan', [AdminController::class, 'searchRelawan'])->name('admin.search.relawan');
            // tambah relawan
            Route::get('/admin/tambah-relawan', [AdminController::class, 'create'])->name('admin.create');
            Route::post('/admin/tambah-relawan', [AdminController::class, 'store'])->name('admin.store');
            // edit relawan
            Route::get('/admin/edit-relawan/{id}', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/admin/edit-relawan/{id}', [AdminController::class, 'update'])->name('admin.update');
            // hapus relawan
            Route::delete('/admin/hapus-relawan/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

            // pendukung
            Route::get('/admin/pendukung', [AdminController::class, 'indexPendukung'])->name('admin.pendukung');

            // kandidat
            Route::get('admin/candidate', [CandidateController::class, 'index'])->name('candidate.index');
            // kandidat detail
            Route::get('/admin/candidate/{id}', [CandidateController::class, 'show'])->name('candidate.show');
            // search kandidat
            Route::get('/search-candidate', [CandidateController::class, 'search'])->name('candidate.search');
            // tambah relawan
            Route::get('/admin/tambah-candidate', [CandidateController::class, 'create'])->name('candidate.create');
            Route::post('/admin/tambah-candidate', [CandidateController::class, 'store'])->name('candidate.store');
            // edit relawan
            Route::get('/admin/edit-candidate/{id}', [CandidateController::class, 'edit'])->name('candidate.edit');
            Route::put('/admin/edit-candidate/{id}', [CandidateController::class, 'update'])->name('candidate.update');
            // hapus relawan
            Route::delete('/admin/hapus-candidate/{id}', [CandidateController::class, 'destroy'])->name('candidate.destroy');
        });
        Route::middleware(['checkRole:1'])->group(function () {
            Route::resource('relawan/quickcount', QuickcountController::class);
            Route::resource('relawan', RelawanController::class);
        });
    });
});
