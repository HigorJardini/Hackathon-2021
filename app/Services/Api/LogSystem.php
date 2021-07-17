<?php

namespace App\Services\Api;

use App\Models\LogsSystem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Exception;

class LogSystem
{
    public function log_system_error($http_code, $function, $th)
    {
        LogsSystem::create([
            'user_id'       => Auth::check() ? Auth::id() : null,
            'origin'        => $function,
            'http_code'     => $http_code,
            'content_error' => json_decode($th->getMessage()) != null ? $th->getMessage() : json_encode([
                                    'invalid_data' => true,
                                    'content'      => $th->getMessage()
                               ])
        ]);
    }
}
