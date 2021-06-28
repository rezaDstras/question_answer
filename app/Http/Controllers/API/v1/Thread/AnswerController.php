<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use App\Repositories\AnswerRepository;
use App\Repositories\SubscribeRepository;
use App\Repositories\UserRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    //middleware to give access to unblock user
    public function __construct()
    {
        $this->middleware('user-block')->except([
            //except function that don't need authentication
            'index',
        ]);
    }
    public function index()
    {
        resolve(AnswerRepository::class)->getAllAnswers();

       return response()->json(Response::HTTP_OK);
    }


    public function store(Request $request)
    {

        $request->validate([
           'content'=>'required',
            'thread_id' => 'required'
        ]);

        //Insert Data To Database
        resolve(AnswerRepository::class)->createAnswer($request);

        //Get List Of User Id Which Subscribed To A Thread Id
        $notifiable_users_id=resolve(SubscribeRepository::class)->getNotifiableUsers($request->thread_id);

        //Get User Instance From id
        $notifiable_users=resolve(UserRepositories::class)->findUser($notifiable_users_id);

        //Send NewReplySubmitted Notification to Subscribed Users
        //first parameter -> for user(s) / two parameter -> data
        Notification::send($notifiable_users,new NewReplySubmitted(Thread::find($request->thread_id)));

        //Increase User Score

        //if user create this thread should not get score when reply its answer
        if (Thread::find($request->input('thread_id'))->user_id != auth()->id()){
            // increment (first parameter->name of column user in database , second parameter->rang value we want to increase score)
            auth()->user()->increment('score',10);
        }


        return response()->json([
            "message" => "answer submitted successfully"
        ],Response::HTTP_CREATED);
    }


    public function update(Request $request, Answer $answer)
    {
        $request->validate([
           'content' => 'required',
        ]);

        if (Gate::forUser(auth()->user())->allows('user-answer',$answer)){
            resolve(AnswerRepository::class)->updateAnswer($request,$answer);

            return response()->json([
                "message" => "answer updated successfully"
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                "message" => "access denied"
            ],Response::HTTP_FORBIDDEN);
        }



    }


    public function destroy(Answer $answer)
    {
        if (Gate::forUser(auth()->user())->allows('user-answer',$answer)) {
            resolve(AnswerRepository::class)->deleteAnswer($answer);
            return response()->json([
                "message" => "answer deleted successfully"
            ],Response::HTTP_OK);
        }
        return response()->json([
            "message" => "access denied"
        ],Response::HTTP_FORBIDDEN);
    }


}
