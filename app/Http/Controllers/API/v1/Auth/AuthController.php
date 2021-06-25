<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepositories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //use phpDoc
    /**
     * Register new user
     * @method POST
     * @param Request $request
     */
    public function register(Request $request)
    {

        //validate from input
        $request->validate([
           'name'=>['required'],
            //email should be unique in users table
            'email'=>['required','email','unique:users'],
            'password'=>['required'],
        ]);

        //insert data in user table
        /**
         * refactor code in repository
        */
        resolve(UserRepositories::class)->create($request);


        return response()->json([
            "message" => "user created successfully" ,
        ],201);
    }


    /**
     * @method GET
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        //validate from input
        $request->validate([
            'email'=>['required','email'],
            'password'=>['required'],
        ]);

        if (Auth::attempt($request->only(['email','password']))){
            return response()->json(Auth::user(),200);
        }

        //else
        throw ValidationException::withMessages([
            'message'=>'incorrect conditionals',
        ]);
    }

    /**
     *  Show user's details
     */
    public function user()
    {
        return response()->json(Auth::user(),200);
    }
    public function logout()
    {
        Auth::logout();

        return response()->json([
            "message" => "user logged out successfully",
        ],200);
    }


}
