<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;

Route::get('/ping', function () {
    return ['pong' => true];
});

/* Login e Logout */
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);

/* Cadastro */
Route::post('/user', [AuthController::class, 'create']);
Route::get('/user', [UserController::class, 'read']);
Route::put('/user', [UserController::class, 'update']);
Route::get('/user/favorities', [UserController::class, 'getFavorities']);
Route::post('/user/favorities', [UserController::class, 'addFavorite']);
Route::get('/user/appoinments', [UserController::class, 'getAppoinments']);

/* Barbeiro */
Route::get('barber', [BarberController::class, 'list']);
Route::get('/barber/{id}', [BarberController::class, 'one']);
Route::get('/search', [BarberController::class, 'search']);
Route::post('/barber/{id}/appointment', [BarberController::class, 'setAppointment']);
