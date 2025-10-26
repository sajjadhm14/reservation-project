<?php

use App\Http\Controllers\User\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;


//routes for user auth
Route::prefix('user/auth')->group(function () {

    Route::prefix(\App\Http\Controllers\User\Auth\RegisterController::class)->group(function () {
        Route::get('register' ,  'index')->name('user.register');
        Route::post('register/post' , 'registerPost')->name('user.register.post');
    });

    Route::controller(\App\Http\Controllers\User\Auth\LoginController::class)->group(function () {
        Route::get('login' , 'index')->name('user.login');
        Route::post('login/post' ,  'loginPost')->name('user.login.post');
    });

});

//routes for user
Route::prefix('user')->middleware('auth')->group(function () {
    // routes for user dashboard
    Route::controller(\App\Http\Controllers\User\Dashboard\DashboardController::class)->group(function () {
        Route::get('dashboard' , 'index')->name('user.dashboard');
        Route::get('logout' , 'logout')->name('user.logout');
    });

});

// routes for consulter auth
Route::prefix('consulter/auth')->group(function () {
    Route::controller(\App\Http\Controllers\Consulter\Auth\ConsulterRegisterController::class)->group(function () {
        Route::get('register' ,  'index')->name('consulter.register');
        Route::post('register/post' , 'registerPost')->name('consulter.register.post');
    });
    Route::controller(\App\Http\Controllers\Consulter\Auth\ConsulterLoginController::class)->group(function () {
        Route::get('login' ,'index')->name('consulter.login');
        Route::post('login/post' , 'loginPost')->name('consulter.login.post');
    });

});


Route::prefix('consulter')->middleware('consulter_middleware')->group(function () {
    Route::controller(\App\Http\Controllers\Consulter\Dashboard\ConsulterDashboardController::class)->group(function () {
        Route::get('dashboard' , 'index')->name('consulter.dashboard');
        Route::get('logout' , 'logout')->name('consulter.logout');
    });

});
