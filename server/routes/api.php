<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// AUTH APIS
Route::prefix('auth') -> group(function () {
    // REGISTER ROUTE
    Route::post('/register', [AuthController::class, 'register'])->name("register_api");
    // LOGIN ROUTE
    Route::post('/login', [AuthController::class, 'login'])->name("login_api");
});

// AUTHENTICATED ROUTES
Route::middleware([AuthMiddleware::class])->group(function () {
    // LOGOUT ROUTE
    Route::prefix('auth') -> group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name("logout_api");
    });
    // FAVOURITE ROUTE
    Route::prefix('movie') -> group(function () {
        Route::post('/add/{imdb_id}', [MovieController::class, 'add_to_favourite'])->name('add_to_favourite');
        Route::delete('/delete/{imdb_id}', [MovieController::class, 'delete_from_favourites'])->name('delete_from_favourites');
        Route::post('/favourite', [MovieController::class, 'get_favourites'])->name('get_favourites');
    });
});

// MOVIES ROUTES
Route::prefix('movie') -> group(function () {
    Route::get('/', [MovieController::class, 'get_movies'])->name("get_movies_api");
    Route::get('/similar/{type}', [MovieController::class, 'get_similar_movies'])->name("get_similar_movies");
    Route::get('/{imdb_id}', [MovieController::class, 'get_movie_by_imdb_id'])->name("get_movie_by_imdb_id");
});
