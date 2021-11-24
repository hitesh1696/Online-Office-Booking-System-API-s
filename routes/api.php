<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\{
    TagController,
    OfficeController,
    OfficeImageController,
    UserReservationController,
    HostReservationController,
    AuthController
};

// Public Routes
Route::post('/register',[AuthController::class, 'register']); //tested
Route::post('/login',[AuthController::class, 'login']); //tested
Route::get('/login',[AuthController::class, 'showLogin'])->name('login'); //tested

// Tags...
Route::get('/tags', TagController::class); //tested

// Offices...
Route::get('/offices', [OfficeController::class, 'index']); //tested
Route::get('/offices/{office}', [OfficeController::class, 'show']); //tested

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/users',[AuthController::class, 'index']);  //tested
    Route::post('/logout',[AuthController::class, 'logout']); //tested
    Route::post('/users/search/{name}',[AuthController::class, 'search']);  

    Route::post('/offices', [OfficeController::class, 'create']); //tested
    Route::put('/offices/{office}', [OfficeController::class, 'update']); //tested
    Route::delete('/offices/{office}', [OfficeController::class, 'delete']); //tested

    // Office Photos...
    Route::post('/offices/{office}/images', [OfficeImageController::class, 'store']); //tested
    Route::delete('/offices/{office}/images/{image:id}', [OfficeImageController::class, 'delete']);  //tested

    // User Reservations...
    Route::get('/reservations', [UserReservationController::class, 'index']); //tested
    Route::post('/reservations', [UserReservationController::class, 'create']); //tested

    // User Reservations...
    Route::get('/host/reservations', [HostReservationController::class, 'index']);
});