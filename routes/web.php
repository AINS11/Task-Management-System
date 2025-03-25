<?php

use App\Http\Controllers\AuthenticateUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\JwtCookieMiddleware::class])->group(function () {

    Route::get('/', function () {
        return view('dashbaord');
    });

});

Route::get('/login', function () {
    return view('Authenticate.login');
});

Route::get('/register', function () {
    return view('Authenticate.register');
});

Route::post('/login', [AuthenticateUser::class, 'loginSubmit'])->name('login');

Route::post('/register', [AuthenticateUser::class, 'registerubmit'])->name('register');