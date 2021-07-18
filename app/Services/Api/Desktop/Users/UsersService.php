<?php

namespace App\Http\Services\Api\Desktop\Users;

use App\Models\User;

use App\Services\Api\LogSystem;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

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

            $users = $this->users->select('id', 'chapa_number', 'name', 'email', 'cpf', 'active')
                                 ->where('adm', 1)
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
        DB::beginTransaction();

        try {
            
            $update = $this->users->where('id', $user_id)
                                ->update([
                                    'active' => $active
                                ]);

            if($update){
                DB::commit();
                return [
                    'http_code' => 200,
                    'return'   => ['message' => 'User updated']
                ];
            } else {
                DB::rollBack();
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'User not updated']
                ];                 
            }

        } catch (\Throwable $th) {

            DB::rollBack();

            $this->logSystem->log_system_error(500, 'UsersService/list()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'User update error']
            ]; 
        }
    }

    public function editUser($request)
    {
        DB::beginTransaction();

        try {

            $user_get = $this->users->where('id', $request->user_id)
                                    ->first();
            
            $rules = [];
            $update = [];

            if(isset($request->password)){
                $rules['password'] = 'min:6';
                $update['password'] = bcrypt($request->password);
            }

            if(isset($request->cpf)){
                if($request->cpf != $user_get->cpf){
                    $rules['cpf'] = 'min:11|max:11|unique:users';
                    $update['cpf'] = $request->cpf;
                }
            }

            if(isset($request->name)){
                if($request->name != $user_get->name){
                    $rules['name'] = 'max:255';
                    $update['name'] = $request->name; 
                }
            }

            if(isset($request->email)){
                if($request->email != $user_get->email){
                    $rules['email'] = 'email|unique:users';
                    $update['email'] = $request->email;
                }
            }

            if(isset($request->chapa_number)){
                if($request->chapa_number != $user_get->chapa){
                    $rules['chapa_number'] = 'min:1';
                    $update['chapa_number'] = $request->chapa_number;
                }
            }

            if(!empty($rules)){
                $validator = $this->validator($request, $rules);

                if ($validator->fails()) {
                    
                    DB::rollBack();

                    return [
                        'http_code' => 400,
                        'return'   => ['message' => $validator->messages()]
                    ];
                }
            }

            $user = $this->users->where('id', $request->user_id)
                                ->update($update);

            if($user){
                DB::commit();
                return [
                    'http_code' => 200,
                    'return'   => ['message' => 'User updated']
                ];
            } else{
                DB::rollBack();
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'User not updated']
                ]; 
            }
        } catch (\Throwable $th) {

            DB::rollBack();

            $this->logSystem->log_system_error(500, 'UsersService/list()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'User update error']
            ]; 
        }
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
