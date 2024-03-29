<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Quickcount\QuickcountController;
use App\Http\Controllers\Relawan\RelawanController;
use App\Http\Controllers\Util\IndonesiaAreaController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::user()) {
        if (Auth::user()->role == 0)
            return redirect()->route('dashboard.admin');
        else if (Auth::user()->role == 1)
            return redirect()->route('dashboard.relawan');
    }
    return redirect()->route('auth.login');
});

Route::controller(AuthController::class)
    ->name('auth.')
    ->prefix('/auth')
    ->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'loginPost')->name('loginPost');
        Route::get('/logout', 'logout')->name('logout');
        // Route::get('/register', 'register')->name('register');
        // Route::post('/register', 'registerPost')->name('registerPost');
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
            Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
            // relawan
            Route::get('/admin/relawan', [AdminController::class, 'index'])->name('admin.index');
            // search relawan
            Route::get('/admin/relawan/search', [AdminController::class, 'searchRelawan'])->name('admin.search.relawan');
            // tambah relawan
            Route::get('/admin/relawan/create', [AdminController::class, 'create'])->name('admin.create');
            Route::post('/admin/relawan', [AdminController::class, 'store'])->name('admin.store');
            // edit relawan
            Route::get('/admin/relawan/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/admin/relawan/{id}', [AdminController::class, 'update'])->name('admin.update');
            // hapus relawan
            Route::delete('/admin/relawan/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
            // pendukung
            Route::get('/admin/pendukung/export', [AdminController::class, 'exportPendukung'])->name('admin.export.pendukung');
            Route::get('/admin/pendukung', [AdminController::class, 'indexPendukung'])->name('admin.pendukung');
            Route::get('/admin/pendukung/search', [AdminController::class, 'searchPendukung'])->name('admin.search.pendukung');
            // search kandidat
            Route::get('/admin/candidate/search', [CandidateController::class, 'search'])->name('candidate.search');
            // tambah relawan
            Route::get('/admin/candidate/create', [CandidateController::class, 'create'])->name('candidate.create');
            // kandidat
            Route::get('admin/candidate', [CandidateController::class, 'index'])->name('candidate.index');
            // kandidat detail
            Route::get('/admin/candidate/{id}', [CandidateController::class, 'show'])->name('candidate.show');
            // tambah kandidat
            Route::post('/admin/candidate', [CandidateController::class, 'store'])->name('candidate.store');
            // edit relawan
            Route::get('/admin/candidate/edit/{id}', [CandidateController::class, 'edit'])->name('candidate.edit');
            Route::put('/admin/candidate/{id}', [CandidateController::class, 'update'])->name('candidate.update');
            // hapus relawan
            Route::delete('/admin/candidate/{id}', [CandidateController::class, 'destroy'])->name('candidate.destroy');
        });

        Route::middleware(['checkRole:1'])->group(function () {
            Route::get('/relawan', [RelawanController::class, 'dashboard'])->name('relawan');
            // search penduduk
            Route::get('relawan/search-penduduk', [RelawanController::class, 'searchPenduduk'])->name('relawan.penduduk.search');
            Route::get('/relawan/pendukung', [RelawanController::class, 'index'])->name('relawan.pendukung');
            Route::get('/relawan/pendukung/search', [RelawanController::class, 'search'])->name('relawan.pendukung.search');
            Route::get('/relawan/quickcount/search', [QuickcountController::class, 'search'])->name('relawan.quickcount.search');
            Route::get('/relawan/pendukung/create', [RelawanController::class, 'create'])->name('relawan.pendukung.create');
            Route::get('relawan/pendukung/create-manual', [RelawanController::class, 'createManual'])->name('relawan.pendukung.create-manual');
            Route::post('/relawan/pendukung', [RelawanController::class, 'store'])->name('relawan.pendukung.store');
            Route::post('relawan/pendukung/store-manual', [RelawanController::class, 'storeManual'])->name('relawan.pendukung.store-manual');
            Route::get('/relawan/pendukung/export', [RelawanController::class, 'exportPendukung'])->name('relawan.pendukung.export');
            Route::get('/relawan/pendukung/edit/{id}', [RelawanController::class, 'edit'])->name('relawan.pendukung.edit');
            Route::put('/relawan/pendukung/{id}', [RelawanController::class, 'update'])->name('relawan.pendukung.update');
            Route::delete('/relawan/pendukung/{id}', [RelawanController::class, 'destroy'])->name('relawan.pendukung.destroy');
            Route::resource('relawan/quickcount', QuickcountController::class)->except(['create']);
            Route::get('/relawan/quickcount/vote', [QuickcountController::class, 'vote'])->name('relawan.quickcount.vote');
        });
    });
});
