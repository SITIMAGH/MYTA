<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    // Route::get('home', function () {
    //     return view('pages.homepage.index');
    // })->name('home');
    Route::get('home', [DashboardController::class, 'index'])->name('home');

    Route::resource('transactions', TransactionController::class);
    Route::resource('product', ProductController::class);

    Route::resource('user', UserController::class)->middleware('userAkses:owner');
    Route::resource('history', HistoryController::class)->middleware('userAkses:owner');
    Route::get('exportHistoryAll', [HistoryController::class, 'exportHistoryAll'])->name('exportPDF.historyAll')->middleware('userAkses:owner');
});
