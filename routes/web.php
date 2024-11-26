<?php

use App\Http\Controllers\AlokasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\ManageUserController;
use App\Models\Lahan;
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
    return view('welcome');
})->name('login');

Route::get('/registrasi', function(){
    return view('registrasi');
});

Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/registrasi', [AuthController::class, 'registrasi']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'role:user'], function () {
    Route::get('/user/dashboard', [DashboardController::class, 'index']);
    Route::get('/user/data-lahan', [LahanController::class, 'index']);
    Route::get('/user/add-lahan', function(){
        $nama_pemilik = Lahan::pluck('pemilik_lahan')->unique()->toArray();

        return view('users.input-data-lahan', ['nama_pemilik' => $nama_pemilik]);
    });
    Route::post('/submit-data-lahan', [LahanController::class, 'store']);
    Route::get('/user/update-data-lahan/{id}', [LahanController::class, 'edit_lahan']);
    Route::put('/update-data-lahan/{id}', [LahanController::class, 'update']);
    Route::get('/user/data-alokasi/{id}', [LahanController::class, 'detail_lahan']);
    Route::put('/update-status-lahan/{id}', [LahanController::class, 'update_status']);
});

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/data-lahan', [LahanController::class, 'index']);

    Route::get('/admin/detail-lahan/{id}', [LahanController::class, 'detail_lahan']);

    Route::post('/alokasi-pupuk/store/{id}', [AlokasiController::class, 'store']);
    Route::put('/alokasi-pupuk/{id}/update', [AlokasiController::class, 'update']);

    Route::get('/admin/manage-user', [ManageUserController::class, 'index']);
    Route::post('/store-new-user', [ManageUserController::class, 'store']);
    Route::put('/admin/{id}/update', [ManageUserController::class, 'update']);
    Route::delete('/admin/{id}/delete', [ManageUserController::class, 'destroy']);
});
