<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\GoogleController;

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
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {
    // Event
    Route::prefix('event')->group(function() {
        Route::get('/', [EventController::class, 'index'])->name('event.index');
        Route::post('/', [EventController::class, 'store'])->name('event.store');
        Route::prefix('{event_id}')->group(function() {
            Route::put('/', [EventController::class, 'edit'])->name('event.edit');
            Route::delete('/', [EventController::class, 'delete'])->name('event.delete');
            // Pendaftaran
            Route::prefix('pendaftaran')->group(function() {
                Route::get('/', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
                Route::post('/', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
                Route::put('{pendaftaran_id}', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
                Route::delete('{pendaftaran_id}', [PendaftaranController::class, 'delete'])->name('pendaftaran.delete');

                Route::get('/form/{pendaftaran_id?}', [PendaftaranController::class, 'form'])->name('pendaftaran.form');
                Route::put('/berhasil_datang/{pendaftaran_id}', [PendaftaranController::class, 'berhasil_datang'])->name('pendaftaran.berhasil_datang');
                Route::put('/berhasil_vaksin/{pendaftaran_id}', [PendaftaranController::class, 'berhasil_vaksin'])->name('pendaftaran.berhasil_vaksin');
                Route::get('/formulir_pendaftaran/{pendaftaran_id}', [PendaftaranController::class, 'formulir_pendaftaran'])->name('pendaftaran.formulir_pendaftaran');
            });
        });
        Route::get('/form/{event_id?}', [EventController::class, 'form'])->name('event.form');
        Route::get('cetak-daftar-hadir/{event_id}', [EventController::class, 'cetak_daftar_hadir'])->name('event.cetak-daftar-hadir');
    });

    // User Management
    Route::group(['middleware' => ['role:Admin']], function () {
        Route::prefix('user')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::post('/', [UserController::class, 'store'])->name('user.store');
            Route::put('/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
    
            Route::get('/form/{id?}', [UserController::class, 'form'])->name('user.form');
        });
        Route::prefix('role')->group(function() {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::post('/', [RoleController::class, 'store'])->name('role.store');
            Route::put('/{id}', [RoleController::class, 'edit'])->name('role.edit');
            Route::delete('/{id}', [RoleController::class, 'delete'])->name('role.delete');
    
            Route::get('/form/{id?}', [RoleController::class, 'form'])->name('role.form');
        });
        Route::prefix('permission')->group(function() {
            Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
            Route::post('/', [PermissionController::class, 'store'])->name('permission.store');
            Route::put('/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
            Route::delete('/{id}', [PermissionController::class, 'delete'])->name('permission.delete');
    
            Route::get('/form/{id?}', [PermissionController::class, 'form'])->name('permission.form');
        });
    });
});