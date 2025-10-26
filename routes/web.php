<?php

use App\Http\Controllers\User\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;


//routes for user auth
Route::prefix('user/auth')->group(function () {
    Route::get('register' , [\App\Http\Controllers\User\Auth\RegisterController::class , 'index'])->name('user.register');
    Route::post('register/post' , [\App\Http\Controllers\User\Auth\RegisterController::class , 'registerPost'])->name('user.register.post');
    Route::get('login' , [\App\Http\Controllers\User\Auth\LoginController::class , 'index'])->name('user.login');
    Route::post('login/post' , [\App\Http\Controllers\User\Auth\LoginController::class , 'loginPost'])->name('user.login.post');
});

//routes for user
Route::prefix('user')->middleware('auth')->group(function () {
    // routes for user dashboard
   Route::get('dashboard' , [DashboardController::class , 'index'])->name('user.dashboard');
   Route::get('logout' , [DashboardController::class , 'logout'])->name('user.logout');
});

// routes for consulter auth
Route::prefix('consulter/auth')->group(function () {
    Route::get('register' , [\App\Http\Controllers\Consulter\Auth\ConsulterRegisterController::class , 'index'])->name('consulter.register');
    Route::post('register/post' , [\App\Http\Controllers\Consulter\Auth\ConsulterRegisterController::class , 'registerPost'])->name('consulter.register.post');
    Route::get('login' ,[\App\Http\Controllers\Consulter\Auth\ConsulterLoginController::class , 'index'])->name('consulter.login');
    Route::post('login/post' , [\App\Http\Controllers\Consulter\Auth\ConsulterLoginController::class , 'loginPost'])->name('consulter.login.post');
});


Route::prefix('consulter')->middleware('consulter_middleware')->group(function () {
    Route::get('dashboard' , [\App\Http\Controllers\Consulter\Dashboard\ConsulterDashboardController::class , 'index'])->name('consulter.dashboard');
    Route::get('logout' , [\App\Http\Controllers\Consulter\Dashboard\ConsulterDashboardController::class , 'logout'])->name('consulter.logout');
});
