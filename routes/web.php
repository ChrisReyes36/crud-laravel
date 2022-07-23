<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::controller(EmpleadoController::class)->group(function () {
        Route::get('/empleado', 'index');
        Route::get('/empleado/create', 'create');
        Route::post('/empleado', 'store');
        Route::get('/empleado/{id}', 'show');
        Route::get('/empleado/{id}/edit', 'edit');
        Route::put('/empleado/{id}', 'update');
        Route::delete('/empleado/{id}', 'destroy');
    });
});
