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
        return response()->json($this->usersService->list());
    }

}
