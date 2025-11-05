<?php

use App\Http\Controllers\User\Transactions\GatewayController;
use App\Http\Controllers\User\Transactions\WalletController;
use Illuminate\Support\Facades\Route;


//routes for user auth
Route::prefix('user/auth')->group(function () {

    Route::controller(\App\Http\Controllers\User\Auth\RegisterController::class)->prefix('register')->group(function () {
        Route::get(uri:'/' ,  action:'index')->name('user.register');
        Route::post(uri:'/post' , action:'registerPost')->name('user.register.post');
    });

});

Route::controller(\App\Http\Controllers\User\Auth\LoginController::class)->group(function () {
    Route::get(uri:'/' , action:'index')->name('user.login');
    Route::post(uri:'login/post' ,  action:'loginPost')->name('user.login.post');
});

//routes for user
Route::prefix('user')->middleware('user_middleware')->group(function () {
    // routes for user dashboard
    Route::controller(\App\Http\Controllers\User\Dashboard\DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get(uri:'/' , action:'index')->name('user.dashboard');
        Route::get(uri:'logout' , action:'logout')->name('user.logout');
    });

    Route::controller(\App\Http\Controllers\User\Dashboard\ReservationController::class)->prefix('reservations')->group(function () {
        Route::get(uri:'/' , action:'index')->name('reservation');
        Route::post(uri:'/post' , action:'reservationPost')->name('reservation.post');
    });
    Route::controller(\App\Http\Controllers\User\Dashboard\SubmitReservationController::class)->prefix('submit')->group(function () {
       Route::get(uri:'/' , action:'index')->name('submit');
       Route::post(uri:'/post/{id}' , action:'submitPost')->name('submit.post');
    });

    Route::controller(WalletController::class)->prefix('wallet')->group(function () {
       Route::get(uri:'/' , action:'index')->name('wallet');
       Route::get(uri:'charge' , action:'walletCharge')->name('wallet.charge');
    });

    Route::controller(GatewayController::class)->prefix('payment')->group(function () {
        Route::get('/' , fn()=>redirect()->route('wallet'));
        Route::post(uri:'/post', action:'paymentPost')->name('payment.post');
        Route::get(uri:'/callback',  action:'callback')->name('payment.callback');
        Route::post(uri:'/callback/post',  action:'callbackPost')->name('payment.callback.post');

    });
//
    Route::controller(\App\Http\Controllers\User\Transactions\ReservationPaymentController::class)->prefix('reserve/payment')->group(function () {
        Route::get(uri:'/' , action:'index')->name('reservation.payment');
        Route::post(uri:'/post/{id}' , action:'paymentPost')->name('reservation.payment.post');
    });


});

// routes for consulter auth
Route::prefix('consulter/auth')->group(function () {
    Route::controller(\App\Http\Controllers\Consulter\Auth\ConsulterRegisterController::class)->prefix('register')->group(function () {
        Route::get('/' ,  'index')->name('consulter.register');
        Route::post('/post' , 'registerPost')->name('consulter.register.post');
    });
    Route::controller(\App\Http\Controllers\Consulter\Auth\ConsulterLoginController::class)->prefix('login')->group(function () {
        Route::get('' ,'index')->name('consulter.login');
        Route::post('/post' , 'loginPost')->name('consulter.login.post');
    });

});


Route::prefix('consulter')->middleware('consulter_middleware')->group(function () {
    Route::controller(\App\Http\Controllers\Consulter\Dashboard\ConsulterDashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/' , 'index')->name('consulter.dashboard');
        Route::get('/logout' , 'logout')->name('consulter.logout');
    });

    Route::controller(\App\Http\Controllers\Consulter\Dashboard\CalenderController::class)->prefix('calender')->group(function () {
        Route::get('/' , 'index')->name('consulter.calender');
        Route::post('/post' , 'calenderPost')->name('consulter.set.calender');
        Route::delete('/delete/{id}' , 'destroy')->name('consulter.delete.calender');
    });
});
