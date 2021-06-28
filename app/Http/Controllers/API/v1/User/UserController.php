<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepositories;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function userNotification()
    {
        //get all notification list
        //  auth()->user()->notifications();

        //get unread notification list of user
         return response()->json(auth()->user()->unreadNotifications() , Response::HTTP_OK);
    }

    public function leaderboards()
    {
        return resolve(UserRepositories::class)->leaderboards();

    }
}
