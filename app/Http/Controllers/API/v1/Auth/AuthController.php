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
use Symfony\Component\HttpFoundation\Response;

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
        $user = resolve(UserRepositories::class)->create($request);


        //use defined default super admin email data config->permission.php
        $defaultSuperAdminEmail= config('permission.default_super_admin_email');


        /*
         * we defined default roles in config ->permission.php
         * if user have not registered before //if exist
         * use spaite package for give role to user
         *
         * */
         $user->email === $defaultSuperAdminEmail ? $user->assignRole('Super Admin') : $user->assignRole('User');


        return response()->json([
            "message" => "user created successfully" ,
        ],Response::HTTP_CREATED);
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
            return response()->json(Auth::user(),Response::HTTP_OK);
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
        $data = [
            //return user detail
            Auth::user(),
            //return un read notification of user
           'notifications'=> Auth::user()->unreadNotifications(),
        ];
        return response()->json($data,Response::HTTP_OK);
    }
    public function logout()
    {
        Auth::logout();

        return response()->json([
            "message" => "user logged out successfully",
        ],Response::HTTP_OK);
    }


}
