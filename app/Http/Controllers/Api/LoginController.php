<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
                               )
    {

    }

    public function login(Request $request)
    {
        return response(400,404);
    }
}
