<?php

namespace App\Http\Controllers\API\v1\Subscribe;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends Controller
{
    //middleware to give access to unblock user
    public function __construct()
    {
        $this->middleware('user-block');
    }

    /**
    * we want subscribe thread
    */
    public function subscribe (Thread $thread)
    {
        auth()->user()->subscribes()->create([
            'thread_id'=>$thread->id
        ]);

        return response()->json([
            "message"=> "user subscribed successfully"
        ],Response::HTTP_CREATED);

    }
    /**
    * we want unsubscribe thread
    */
    public function unSubscribe (Thread $thread)
    {
        Subscribe::query()->where([
            ['thread_id',$thread->id],
            ['user_id',auth()->id()]
        ])->delete();

        return response()->json([
            "message"=> "user unsubscribed successfully"
        ],Response::HTTP_OK);

    }
}
