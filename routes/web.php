<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
//debug
Route::get('/', function () {
    return view('testing');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/404', function () {
    return view('404');
});
Route::get('/auth', function () {
    return view('auth');
});
Route::get('/become-tutor', function () {
    return view('become-tutor');
});
Route::get('/browse-tutors', function () {
    return view('browse-tutors');
});
Route::get('/landing', function () {
    return view('landing');
});
Route::get('/tutor-profile', function () {
    return view('tutor-profile');
});
Route::get('/register', function () {
    return view('register');
});

Route::post('/createUser', [UserController::class, 'createUser'])->name('createUser');
Route::post('/createReservation', [ReservationController::class, 'createReservation'])->name('createReservation');
Route::post('/login', [UserController::class, 'login'])->name('login');
