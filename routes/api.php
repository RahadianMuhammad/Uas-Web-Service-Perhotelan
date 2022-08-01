<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');


Route::group(['middleware' => ['auth:api']], function () {

    Route::apiResource('/kamar', App\Http\Controllers\Api\KamarController::class);
    Route::apiResource('/pengunjung', App\Http\Controllers\Api\PengunjungController::class);
    Route::apiResource('/karyawan', App\Http\Controllers\Api\KaryawanController::class);

    Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
});
