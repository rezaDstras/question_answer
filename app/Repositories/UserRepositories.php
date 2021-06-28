<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;

class UserRepositories
{

    public function findUser($id)
    {
        return User::find($id);
    }


    /**
     *
     * @param Request $request
     * @return User
     */
    public function create(Request $request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function leaderboards()
    {
        return User::query()->orderByDesc('score')->paginate(10);
     }

    public function isBlock()
    {
        //return user who is block as boolean
        return (bool) auth()->user()->is_block;
     }
}
