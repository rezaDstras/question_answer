<?php

use Illuminate\Support\Facades\Route;

Route::resource('threads',\App\Http\Controllers\API\v1\Thread\ThreadController::class);

Route::prefix('/threads')->group(function (){
    //answer routes
    Route::resource('answers',\App\Http\Controllers\API\v1\Thread\AnswerController::class);
    //notifications routes
    Route::post('/{thread}/subscribe', [\App\Http\Controllers\API\v1\Subscribe\SubscribeController::class,'subscribe'])->name('subscribe');
    Route::post('/{thread}/unsubscribe', [\App\Http\Controllers\API\v1\Subscribe\SubscribeController::class,'unSubscribe'])->name('unSubscribe');
});

