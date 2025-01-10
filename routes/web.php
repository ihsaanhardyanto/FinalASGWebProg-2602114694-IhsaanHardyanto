<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Landing page
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Guest Routes
Route::middleware('guest')->group(function () {
    // Authentication
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registration with payment
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/register/payment', [RegisterController::class, 'showPaymentForm'])->name('register.payment');
    Route::post('/register/payment', [RegisterController::class, 'processPayment']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // User & Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::post('/profile/visibility', [UserController::class, 'toggleVisibility'])->name('profile.visibility');

    // Friend Requests
    Route::post('/friend-request/{user}', [UserController::class, 'sendFriendRequest'])->name('friend.request');
    Route::put('/friend-request/{request}/handle', [UserController::class, 'handleFriendRequest'])->name('friend.handle');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'send'])->name('messages.send');

    // Transactions & Balance
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/topup', [TransactionController::class, 'topup'])->name('topup');
    Route::post('/purchase/avatar/{avatar}', [TransactionController::class, 'purchaseAvatar'])->name('purchase.avatar');

    // Search & Filter
    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::get('/filter', [UserController::class, 'filter'])->name('filter');
});

// Fallback route
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});