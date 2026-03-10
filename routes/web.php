<?php

use App\Http\Controllers\CouponBanditController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyRewardsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// This page contains most of the main routing logic for the entire site

// We use the 'guest' profile in the middleware to serve the login page, the request to login, and the bypass for the login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
    Route::post('/login/demo', [LoginController::class, 'demoLogin'])->name('login.demo');
});

// *** Logged in users ***
// *** 'auth' middleware profile ***
//
// This is all the routing logic for users that are logged in
Route::middleware('auth')->group(function () {
    // *** Home page ***
    //
    Route::get('/', [CouponBanditController::class, 'index'])->name('home');
    // Log out and redirect back to login page
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // *** Stores ***
    //
    // "Stores" tab on navbar 
    Route::get('/stores', [MerchantController::class, 'index'])->name('merchants.index');
    // Specific store by merchant_id
    Route::get('/stores/{id}', [MerchantController::class, 'show'])->whereNumber('id')->name('merchants.show');

    // *** Categories ***
    //
    // "Categories" tab on main navbar 
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/deals', [DealsController::class, 'index'])->name('deals.index');


    // *** My Rewards ***
    //
    // "My Rewards" tab on main navbar 
    Route::get( '/my_rewards', [MyRewardsController::class, 'index'])->name('my_rewards.index');
    Route::get( '/my_rewards_test', [MyRewardsController::class, 'test'])->name('my_rewards.test');

    // *** Favorite item ***
    //
    // "My Rewards" tab on main navbar 
    Route::post( '/favorites/toggle/{deal_id}', [UserController::class, 'toggleFavorite'])->name('favorites.toggle');
    



    // Global fallback
    // Covers any URL that falls through the crack of individual fallbacks
    // We either redirect to the homepage if coming from an invalid url, or back to the url the user was on before
    Route::fallback(function () {
        // First we'll get the previous page.
        // Why? - We have to see if the previous page is a valid page. If it is, we'll redirect back there
        $previous = url()->previous();

        // Since it's easier to check if it's invalid, we'll check that first
        // If previous is null or the previous url is invalid and the same as before
        if (!$previous || $previous === url()->current()) {
            return redirect()->route('home');
        }
        // Valid link redirect to previous page
        else {
            return redirect()->to($previous);
        }
    });
});
