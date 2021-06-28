<?php

use Illuminate\Support\Facades\Route;

//we can write route code in routeServiceProvider instead of here

Route::prefix('v1/')->group(function (){

    //Authentication Routes
    include __DIR__ . '/v1/Auth_routes.php';

    //Channel routes
    include __DIR__ . '/v1/Channel_routes.php';

    //Thread routes
    include __DIR__ . '/v1/Thread_routes.php';


});

