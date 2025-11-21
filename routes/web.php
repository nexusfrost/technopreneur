<?php

use App\Http\Controllers\BrowseTutorController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
//debug
Route::get('/', function () {
    return view('testing');
});

Route::get('/404', function () {
    return view('404');
});
Route::get('/auth', function () {
    return view('auth');
});

Route::get('/browse-tutors', function () {
    return view('browse-tutors');
})->name('browse-tutors');
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
Route::post('/login', [UserController::class, 'login'])->name('login');


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TutorProfileController;

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

// Your other routes...

// Route::get('/dashboard', function () {
//     // You would fetch the user and tutor profile data here to pass to the view
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');


// Routes for the dashboard forms, protected by auth middleware
Route::middleware('auth')->group(function () {


    // Route for the "Edit Profile" modal form
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Route for the "Become a Tutor" modal form
    Route::post('/tutor-profile', [TutorProfileController::class, 'createTutorProfile'])->name('tutor-profile.store');
    Route::post('/createReservation', [ReservationController::class, 'createReservation'])->name('createReservation');

    // Route for the "Edit Tutor Profile" modal form
    Route::post('/tutor-profile-update', [TutorProfileController::class, 'updateTutorProfile'])->name('tutor-profile.update');
});

//EXPERIMENTAL

    // Dashboard routes
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
//pages
Route::get('/browse-tutors',[BrowseTutorController::class,'index'])->name('browse-tutors');
Route::get('/search-tutors',[BrowseTutorController::class,'search'])->name('search-tutors');
Route::get('/tutor/{tutorProfile}',[TutorProfileController::class, 'viewTutor'])->name('view-tutor');
Route::post('/cashout',[])->name('cashout.request');

// reservations
Route::patch('/update-link/{reservation}',[ReservationController::class,'updateLink'])->name('updateLink');
Route::patch('/accept/{reservation}',[ReservationController::class,'accept'])->name('accept');
Route::patch('/reject/{reservation}',[ReservationController::class,'reject'])->name('reject');
Route::patch('/dp/{reservation}',[ReservationController::class,'downPayment'])->name('dp');
Route::patch('/cancel/{reservation}',[ReservationController::class,'cancel'])->name('cancel');
Route::patch('/end/{reservation}',[ReservationController::class,'end'])->name('cancel');
Route::patch('/rate/',[ReservationController::class,'storeRating'])->name('ratings.store');
Route::post('/store/',[ReservationController::class,'createReservation'])->name('reservations.store');

// dashboard
Route::post('/cashout/',[ReservationController::class,'cashout'])->name('cashout');
Route::post('/logout/',[UserController::class,'logout'])->name('logout');

// chat
Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/{user}', [ChatController::class, 'show']); // Get messages
    Route::post('/chat/{user}', [ChatController::class, 'send']); // Send message


// Add other routes like login, register etc.
