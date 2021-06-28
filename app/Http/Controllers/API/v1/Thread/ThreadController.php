<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{
    //middleware to give access to unblock user
    public function __construct()
    {
        $this->middleware('user-block')->except([
            //except function that don't need authentication
            'index',
            'show',
        ]);
    }

    public function index()
    {
        $threads = resolve(ThreadRepository::class)->getAllThreads();

        return response()->json($threads,Response::HTTP_OK);
    }

    public function show ($slug)
    {
        $thread = resolve(ThreadRepository::class)->showThreadBySlug($slug);

        return response()->json($thread,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'channel_id' => 'required'
        ]);

        //insert data in database
        resolve(ThreadRepository::class)->createThread($request);

        return response()->json([
            "message"=>"thread create successfully"
        ],Response::HTTP_CREATED);
    }

    public function update(Request $request ,Thread $thread)
    {

        $request->has('best_answer_id')
            ? $request->validate([
            'best_answer_id' => 'required',
        ])
            : $request->validate([
                'title' => 'required',
                'content' => 'required',
                'channel_id' => 'required'
            ]);

        //we use gate for defining user who created this thread can only update this thread (AuthServiceProvider -> user-thread)
        if (Gate::forUser(auth()->user())->allows('user-thread',$thread)){

            //insert data in database
            resolve(ThreadRepository::class)->UpdateThread($request ,$thread);

            return response()->json([
                "message"=>"thread Updated successfully"
            ],Response::HTTP_OK);

        }else{
            //don't have access
            return response()->json([
                "message"=>"access denied"
            ],Response::HTTP_FORBIDDEN);
        }


    }

    public function destroy(Thread $thread)
    {

        //we use gate for defining user who created this thread can only update this thread (AuthServiceProvider -> user-thread)
        if (Gate::forUser(auth()->user())->allows('user-thread',$thread)){

            //insert data in database
            resolve(ThreadRepository::class)->destroyThread($thread);

            return response()->json([
                "message"=>"thread Deleted successfully"
            ],Response::HTTP_OK);

        }else{
            //don't have access
            return response()->json([
                "message"=>"access denied"
            ],Response::HTTP_FORBIDDEN);
        }


    }




}
