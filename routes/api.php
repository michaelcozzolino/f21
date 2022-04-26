<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\SensorsController;
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

Route::post('/register', [AuthController::class, 'signUp'])->name('users.signUp');

Route::post('/login', [AuthController::class, 'signIn'])->name('users.signIn');

Route::put('/users', [AuthController::class, 'update'])->name('users.update');

Route::post('/logout', [AuthController::class, 'signOut']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/fields', [FieldsController::class, 'store'])->name('fields.store');

    Route::put('/fields/{field}', [FieldsController::class, 'update'])->name('fields.update');

    Route::delete('/fields/{field}', [FieldsController::class, 'destroy'])->name('fields.destroy');

    Route::post('/fields/{field}/sensors', [SensorsController::class, 'store'])->name('fields.sensors.store');

    Route::put('/fields/{field}/sensors/{sensor}', [SensorsController::class, 'update'])->name('fields.sensors.update');

    Route::delete('/fields/{field}/sensors/{sensor}', [SensorsController::class, 'destroy'])->name('fields.sensors.destroy');

  });



