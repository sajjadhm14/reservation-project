<?php

use App\Http\Controllers\User\Transactions\Payment\GatewayController;
use App\Http\Controllers\User\Transactions\Wallet\UserWalletController;
use Illuminate\Support\Facades\Route;


//routes for user auth

Route::controller(\App\Http\Controllers\User\Auth\UserLoginController::class)->group(function () {
    Route::get(uri:'/' , action:'index')->name('user.login');
    Route::post(uri:'login/post' ,  action:'loginPost')->name('user.login.post');
});

Route::prefix('user/register')->group(function () {

    Route::controller(\App\Http\Controllers\User\Auth\UserRegisterController::class)->group(function () {
        Route::get(uri:'/' ,  action:'index')->name('user.register');
        Route::post(uri:'/post' , action:'registerPost')->name('user.register.post');
    });

});



//routes for user
Route::prefix('user')->middleware('user_middleware')->group(function () {
    // routes for user dashboard
    Route::controller(\App\Http\Controllers\User\Dashboard\UserDashboardController::class)->prefix('dashboard')->group(function () {
        Route::get(uri:'/' , action:'index')->name('user.dashboard');
        Route::get(uri:'logout' , action:'logout')->name('user.logout');
    });

    Route::controller(\App\Http\Controllers\User\Dashboard\UserReservationController::class)->prefix('reservations')->group(function () {
        Route::get(uri:'/' , action:'index')->name('reservation');
        Route::post(uri:'/post' , action:'reservationPost')->name('reservation.post');
    });
    Route::controller(\App\Http\Controllers\User\Dashboard\UserSubmitReservationController::class)->prefix('submit')->group(function () {
       Route::get(uri:'/' , action:'index')->name('submit');
       Route::post(uri:'/post/{id}' , action:'submitPost')->name('submit.post');
    });

    Route::controller(UserWalletController::class)->prefix('wallet')->group(function () {
       Route::get(uri:'/' , action:'index')->name('wallet');
       Route::get(uri:'charge' , action:'walletCharge')->name('wallet.charge');
    });

    Route::controller(\App\Http\Controllers\User\Transactions\Payment\StartPaymentController::class)->prefix('startPayment')->group(function () {
        Route::get(uri:'/' , action:'paymentPage')->name('payment.page');
        Route::post(uri:'/post' , action:'paymentPost')->name('payment.post');
    });

    Route::controller(GatewayController::class)->prefix('gateway')->group(function () {
        Route::get('/' , fn()=>redirect()->route('wallet'));
        Route::get(uri:'/callback',  action:'callback')->name('gateway.callback');
        Route::post(uri:'/callback/post',  action:'callbackPost')->name('gateway.callback.post');

    });

//
    Route::controller(\App\Http\Controllers\User\Transactions\Wallet\UserReservationPaymentController::class)->prefix('reserve/payment')->group(function () {
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
