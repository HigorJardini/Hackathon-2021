<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $user;

    public function __construct(
                                 User $user
                               )
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 400);
        }

        $user = $this->user->where('email', $request->email)
                           ->first();

        if(!$user == null){
            if($user->adm == 0)
                return response(['message' => 'User with not access'], 400);
            else if ($user->active == 0)
                return response(['message' => 'User Disabled'], 400);
        } else
            return response(['message' => 'Invalid User'], 400);

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
