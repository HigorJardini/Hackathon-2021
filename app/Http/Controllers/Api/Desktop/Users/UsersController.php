<?php

namespace App\Http\Controllers\Api\Desktop\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Api\Desktop\Users\UsersService;

class UsersController extends Controller
{
    private $usersService;

    public function __construct(
                                  UsersService $usersService
                               )
    {
        $this->usersService = $usersService;
    }

    public function list()
    {   
        $list = $this->usersService->list();
        return response()->json($list['return'], $list['http_code']);
    }

    public function situationUser(Request $request)
    {
        if(isset($request->user_id) && isset($request->active)){
            $update = $this->usersService->situationUser($request->user_id, $request->active);
            return response()->json($update['return'], $update['http_code']);
        } else 
            return response()->json(['message' => 'User_id or Active is Required'], 400);
    }   
    
    public function editUser(Request $request)
    {
        if(isset($request->user_id)){
            $update = $this->usersService->editUser($request);
            return response()->json($update['return'], $update['http_code']);
        } else 
            return response()->json(['message' => 'User_id or Active is Required'], 400);
    }  

}
