<?php

namespace App\Http\Controllers\Api\Desktop;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
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
        $rules = [
            'email'    => 'email|required',
            'password' => 'required'
        ];

        $validator = $this->validator($request, $rules);

        $items = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        $user = $this->user->where('email', $request->email)
                           ->first();

        if(!$user == null){
            if($user->adm == 0)
                return response(['message' => 'User with not access'], 400);
            else if ($user->active == 0)
                return response(['message' => 'User Disabled'], 400);
        } else
            return response(['message' => 'Invalid User'], 400);

        if (!auth()->attempt($items)) {
            return response(['message' => 'Invalid Credentials'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);

    }

    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|max:255',
            'email'    => 'email|required|unique:users',
            'cpf'      => 'required|min:11|max:11|unique:users',
            'password' => 'required|min:6'
        ];

        $validator = $this->validator($request, $rules);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $by_passwd = bcrypt($request->password);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'cpf'      => $request->cpf,
            'password' => $by_passwd,
            'active'   => 1,
            'adm'      => 1
        ]);

        // $accessToken = $user->createToken('authToken')->accessToken;

        return response(['message' => 'User created'], 200);
    }

    private function validator($request, $rules)
    {
        return Validator::make($request->all(), $rules, $messages = [
            'required' => 'The :attribute field is required.',
            'min'      => 'The :attribute dont have min the caracters',
            'max'      => 'The :attribute have max the caracters',
            'unique'   => 'Duplicate :attribute'
        ]);

    }
}
