<?php

use App\Http\Controllers\User\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;


//routes for user auth
Route::prefix('user/auth')->group(function () {

    Route::controller(\App\Http\Controllers\User\Auth\RegisterController::class)->group(function () {
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

    Route::controller(\App\Http\Controllers\User\Dashboard\ReservationController::class)->group(function () {
        Route::get('reservations' , 'index')->name('reservation');
        Route::post('reservations/post' , 'reservationPost')->name('reservation.post');
    });
    Route::controller(\App\Http\Controllers\User\Dashboard\SubmitReservationController::class)->group(function () {
       Route::get('submit' , 'index')->name('submit');
       Route::post('submit/post/{id}' , 'submitPost')->name('submit.post');
    });
    Route::get('ss', function(){
        return 2;
    })->name('ss');
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

    Route::controller(\App\Http\Controllers\Consulter\Dashboard\CalenderController::class)->group(function () {
        Route::get('calender' , 'index')->name('consulter.calender');
        Route::post('calender/post' , 'calenderPost')->name('consulter.set.calender');
        Route::delete('calender/delete/{id}' , 'destroy')->name('consulter.delete.calender');
    });

});
