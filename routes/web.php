<?php

use Illuminate\Support\Facades\Route;

// TODO: FRONT ROUTES
Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/add-to-cart', 'add_to_cart');
    Route::get('/remove-from-cart', 'update');
});
