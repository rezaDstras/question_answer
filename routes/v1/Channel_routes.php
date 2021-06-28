<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\v1\Channel\ChannelController;

/**
 * use role and permission by middleware
*/
Route::prefix('channel')->group(function (){

    Route::get('/all',[
        ChannelController::class,
        'getAllChannels'
    ])->name('channel.all');

  Route::middleware(['can:channel management','auth:sanctum'])->group(function (){
      Route::post('/create',[
          ChannelController::class,
          'createNewChannel'
      ])->name('channel.create');

      Route::put('/update',[
          ChannelController::class,
          'edit'
      ])->name('channel.update');

      Route::delete('/delete',[
          ChannelController::class,
          'delete'
      ])->name('channel.delete');
  });

});
