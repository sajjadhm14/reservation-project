<?php

use App\Http\Controllers\User\Transactions\GatewayController;
use App\Http\Controllers\User\Transactions\WalletController;
use Illuminate\Support\Facades\Route;


//routes for user auth
Route::prefix(prefix:'user/auth')->group(function () {

    Route::controller(controller:\App\Http\Controllers\User\Auth\RegisterController::class)->prefix(prefix:'register')->group(function () {
        Route::get(uri:'/' ,  action:'index')->name(name:'user.register');
        Route::post(uri:'/post' , action:'registerPost')->name('user.register.post');
    });

});

Route::controller(controller:\App\Http\Controllers\User\Auth\LoginController::class)->group(function () {
    Route::get(uri:'/' , action:'index')->name(name:'user.login');
    Route::post(uri:'login/post' ,  action:'loginPost')->name(name:'user.login.post');
});

//routes for user
Route::prefix(prefix:'user')->middleware(middleware:'user_middleware')->group(function () {
    // routes for user dashboard
    Route::controller(controller:\App\Http\Controllers\User\Dashboard\DashboardController::class)->prefix(prefix:'dashboard')->group(function () {
        Route::get(uri:'/' , action:'index')->name(name:'user.dashboard');
        Route::get(uri:'logout' , action:'logout')->name(name:'user.logout');
    });

    Route::controller(controller:\App\Http\Controllers\User\Dashboard\ReservationController::class)->prefix(prefix:'reservations')->group(function () {
        Route::get(uri:'/' , action:'index')->name(name:'reservation');
        Route::post(uri:'/post' , action:'reservationPost')->name(name:'reservation.post');
    });
    Route::controller(controller:\App\Http\Controllers\User\Dashboard\SubmitReservationController::class)->prefix(prefix:'submit')->group(function () {
       Route::get(uri:'/' , action:'index')->name(name:'submit');
       Route::post(uri:'/post/{id}' , action:'submitPost')->name(name:'submit.post');
    });

    Route::controller(controller:WalletController::class)->prefix(prefix:'wallet')->group(function () {
       Route::get(uri:'/' , action:'index')->name(name:'wallet');
       Route::get(uri:'charge' , action:'walletCharge')->name(name:'wallet.charge');
    });

    Route::controller(controller:GatewayController::class)->prefix(prefix:'payment')->group(function () {
        Route::get(uri:'/' , action:'index')->name(name:'payment');
        Route::post(uri:'/post', action:'paymentPost')->name(name:'payment.post');middleware:
        Route::get(uri:'/callback',  action:'callback')->name(name:'payment.callback');

    });
//
    Route::controller(controller:\App\Http\Controllers\User\Transactions\ReservationPaymentController::class)->prefix(prefix:'reserve/payment')->group(function () {
        Route::get(uri:'/' , action:'index')->name(name:'reservation.payment');
        Route::post(uri:'/post/{id}' , action:'paymentPost')->name(name:'reservation.payment.post');
    });


});

// routes for consulter auth
Route::prefix(prefix:'consulter/auth')->group(function () {
    Route::controller(controller:\App\Http\Controllers\Consulter\Auth\ConsulterRegisterController::class)->prefix(prefix:'register')->group(function () {
        Route::get(uri:'/' ,  action:'index')->name(name:'consulter.register');
        Route::post(uri:'/post' , action:'registerPost')->name(name:'consulter.register.post');
    });
    Route::controller(controller:\App\Http\Controllers\Consulter\Auth\ConsulterLoginController::class)->prefix(prefix:'login')->group(function () {
        Route::get(uri:'' ,action:'index')->name(name:'consulter.login');
        Route::post(uri:'/post' , action:'loginPost')->name(name:'consulter.login.post');
    });

});


Route::prefix(prefix:'consulter')->middleware(middleware:'consulter_middleware')->group(function () {
    Route::controller(controller:\App\Http\Controllers\Consulter\Dashboard\ConsulterDashboardController::class)->prefix(prefix:'dashboard')->group(function () {
        Route::get(uri:'/' , action:'index')->name(name:'consulter.dashboard');
        Route::get(uri:'/logout' , action:'logout')->name(name:'consulter.logout');
    });

    Route::controller(controller:\App\Http\Controllers\Consulter\Dashboard\CalenderController::class)->prefix(prefix:'calender')->group(function () {
        Route::get(uri:'/' , action:'index')->name(name:'consulter.calender');
        Route::post(uri:'/post' , action:'calenderPost')->name(name:'consulter.set.calender');
        Route::delete(uri:'/delete/{id}' , action:'destroy')->name(name:'consulter.delete.calender');
    });
});
