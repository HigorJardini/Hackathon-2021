<?php

namespace App\Http\Services\Api\Desktop\Users;

use App\Models\User;

use App\Services\Api\LogSystem;

class UsersService
{
    private $users;
    private $logSystem;

    public function __construct(
                                    User $users,
                                    LogSystem $logSystem
                               )
    {
        $this->users      = $users;
        $this->logSystem  = $logSystem;
    }

    public function list()
    {
        try {

            $users = $this->users->select('id', 'chapa_number', 'name', 'email', 'active')
                               ->get()
                               ->toArray();

            return [
                'http_code' => 200,
                'return'    => $users
            ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'UsersService/list()', $th);
            
            return [
                'http_code' => 500,
                'return'    => []
            ];
        }
    }

    public function situationUser($user_id, $active)
    {
        try {
            
            $update = $this->users->where('id', $user_id)
                                ->update([
                                    'active' => $active
                                ]);

            if($update)
                return [
                    'http_code' => 200,
                    'return'   => ['message' => 'User updated']
                ];
            else
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'User not updated']
                ];                 

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'UsersService/list()', $th);
            
            return null;
        }
    }

}
