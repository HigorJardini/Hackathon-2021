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
            
            return $this->users->select('chapa_number', 'name', 'email', 'active')
                                         ->get()
                                         ->toArray();

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'UsersService/list()', $th);
            
            return null;
        }
    }

}
