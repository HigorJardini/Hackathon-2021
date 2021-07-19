<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPhones;
use App\Models\UserAddress;
use App\Models\Phones;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class AuthController extends Controller
{
    private $user;
    private $userPhones;
    private $userAddress;
    private $phones;
    private $address;

    public function __construct(
                                 User $user,
                                 UserPhones $userPhones,
                                 UserAddress $userAddress,
                                 Phones $phones,
                                 Address $address
                               )
    {
        $this->user = $user;
        $this->userPhones = $userPhones;
        $this->userAddress = $userAddress;
        $this->phones = $phones;
        $this->address = $address;
    }

    public function valid(Request $request)
    {
        $user = $this->user->where('cpf', $request->cpf)
                           ->where('active', 1)
                           ->where('adm', 0)
                           ->first();
        if($user != null){
            $mothers = $this->motherNames($user->mother_name);
            $birthdates = $this->birthdates($user->birthdate);

            return response([
                'message' => 'Next fase', 
                'content_auth' => [
                    'mother'    => $mothers,
                    'birthdate' => $birthdates
                ]
            ], 200);

        } else {
            return response(['message' => 'Invalid User'], 401);
        }
    }

    private function motherNames($real)
    {
        $names = [
            'Alice',
            'Sophia',
            'Helena',
            'Valentina',
            'Laura',
            'Isabella',
            'Manuela',
            'Júlia',
            'Heloísa',
            'Luiza',
            'Maria Luiza',
            'Lorena',
            'Lívia',
            'Giovanna',
            'Maria Eduarda',
            'Beatriz',
            'Maria Clara',
            'Cecília',
            'Eloá',
            'Lara',
            'Maria Júlia',
            'Isadora',
            'Mariana',
            'Emanuelly',
            'Ana Júlia',
            'Ana Luiza',
            'Ana Clara',
            'Melissa',
            'Yasmin',
            'Maria Alice',
            'Isabelly',
            'Lavínia',
            'Esther',
            'Sarah ',
            'Elisa',
            'Antonella',
            'Rafaela ',
            'Maria Cecília',
            'Liz',
            'Marina',
            'Nicole',
            'Maitê',
            'Isis',
            'Alícia',
            'Luna',
            'Rebeca',
            'Agatha',
            'Letícia',
            'Maria',
            'Gabriela',
            'Ana Laura',
            'Catarina',
            'Clara',
            'Ana Beatriz',
            'Vitória',
            'Olívia',
            'Maria Fernanda',
            'Emilly',
            'Maria Valentina',
            'Milena',
            'Maria Helena',
            'Bianca',
            'Larissa',
            'Mirella',
            'Maria Flor',
            'Allana',
            'Ana Sophia',
            'Clarice',
            'Pietra',
            'Maria Vitória',
            'Maya',
            'Laís',
            'Ayla',
            'Ana Lívia',
            'Eduarda',
            'Mariah',
            'Stella',
            'Ana',
            'Gabrielly',
            'Sophie',
            'Carolina',
            'Maria Laura',
            'Maria Heloísa',
            'Maria Sophia',
            'Fernanda',
            'Malu',
            'Analu',
            'Amanda',
            'Aurora',
            'Maria Isis',
            'Louise',
            'Heloise',
            'Ana Vitória',
            'Ana Cecília',
            'Ana Liz',
            'Joana',
            'Luana',
            'Antônia',
            'Isabel',
            'Bruna'
        ];

        $surname = [
            'Albuquerque',
            'Almeida',
            'Alvares',
            'Alves',
            'Amorim',
            'Andrade',
            'Antunes',
            'Aragão',
            'Araújo',
            'Azevedo',
            'Barbosa',
            'Bastos',
            'Batista',
            'Bernardes',
            'Botelho',
            'Camargo',
            'Cardoso',
            'Carmo',
            'Carvalho',
            'Castro',
            'Coelho',
            'Costa',
            'Coutinho',
            'Couto',
            'Cruz',
            'Cunha',
            'Dias',
            'Duarte',
            'Fernandes',
            'Ferreira',
            'Figueiredo',
            'Fonseca',
            'Freitas',
            'Frota',
            'Furtado',
            'Garcia',
            'Gomes',
            'Gonçalves',
            'Lima',
            'Lopes',
            'Machado',
            'Marques',
            'Martins',
            'Mendes',
            'Mesquita',
            'Monteiro',
            'Moraes',
            'Moreira',
            'Moura',
            'Nascimento',
            'Neves',
            'Nunes',
            'Oliveira',
            'Pedrosa',
            'Pereira',
            'Pimentel',
            'Pires',
            'Ramos',
            'Ribeiro',
            'Rocha',
            'Rodrigues',
            'Santana',
            'Santiago',
            'Santos',
            'Silva',
            'Soares',
            'Souza',
            'Simões',
            'Teixeira',
            'Vieira'
        ];

        $rand1 = rand(2,4);
        $case1 = rand(0,$rand1);

        $sub_names = [];

        for($aux = 0; $aux <= $rand1; $aux++){
            $n = $names[rand(0,99)];
            $rand2 = rand(1,3);
            for($aux2 = 0; $aux2 <= $rand2; $aux2++){
                $n .= ' ' . $surname[rand(0,69)];
            }

            if($case1 == $aux)
                $sub_names[] = strtolower($real);
            else
                $sub_names[] = strtolower($n);
        }

        return $sub_names;
    }

    private function birthdates($real)
    {
        $rand1 = rand(2,4);
        $case1 = rand(0,$rand1);

        $sub_datas = [];

        for($aux = 0; $aux <= $rand1; $aux++){
            $new_year = Carbon::now()->subYear(rand(18, 90))->format('Y');
            $new_data = Carbon::createFromDate($new_year, rand(1, 12), rand(1, 31))->format('d/m/Y');

            if($case1 == $aux)
                $sub_datas[] = date('d/m/Y', strtotime($real));
            else
                $sub_datas[] = $new_data;
        }

        return $sub_datas;
    }

    public function login(Request $request)
    {
        $user = $this->user->where('cpf', $request->cpf)
                           ->first();
        
        $date_convert = Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d');

        if((strtolower($request->mother_name) == strtolower($user->mother_name)) && (strtotime($date_convert) == strtotime($user->birthdate))){
            $accessToken = $user->createToken('authToken')->accessToken;
            return response(['user' => $user, 'access_token' => $accessToken], 200);
        } else
        return response(['message' => 'Invalid Login Access'], 400);

    }

    public function register(Request $request)
    {
        $rules = [
            'name'        => 'required|max:255',
            'cpf'         => 'required|min:11|max:11|unique:users',
            'mother_name' => 'required|min:1|max:255',
            'birthdate'   => 'required|min:10|max:10'
        ];

        $validator = $this->validator($request, $rules);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        
        $user = User::create([
            'name'         => $request->name,
            'cpf'          => $request->cpf,
            'mother_name'  => $request->mother_name,
            'birthdate'    => $request->birthdate,
            'active'       => 1,
            'adm'          => 0
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['message' => 'User created', 'user' => $user, 'access_token' => $accessToken], 200);
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
