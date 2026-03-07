<?php

use App\Http\Controllers\CouponBanditController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
});
Route::middleware('auth')->group(function () {
    Route::get('/', [CouponBanditController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/stores', [MerchantController::class, 'index'])->name('merchants.index');
    Route::get('/stores/{id}', [MerchantController::class, 'show'])
        ->whereNumber('id')
        ->name('merchants.show');
    Route::get('/stores/{invalid}', function () {
        return redirect()->route('merchants.index');
    });

    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/deals', [DealsController::class, 'index'])->name('deals.index');

    // Global fallback - couponbandit.test/this/doesnt/exist
    // Covers any url that falls through the crack of individual fallbacks
    // We either redirect to the homepage if coming from an invalid url, or back to the url the user was on before
    Route::fallback(function () {
        // First we'll get the previous page.
        // Why? - We have to see if it's a valid page. If it is, we'll redirect back there
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
