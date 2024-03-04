<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['execept' => ['create', 'login']]);
    }
    public function create(Request $request)
    {
        /* VALIDA OS DADOS ENVIADOS */
        $array = ['error' => ''];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        /* CASO OS DADOS ESTEJAM INCORRETOS */
        if ($validator->fails()) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            /* Verifica se o email ja existi */
            $emailExists = User::where('email', $email)->count();
            if ($emailExists === 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $newUser = new User();
                $newUser->name = $name;
                $newUser->email = $email;
                $newUser->password = $password;
                $newUser->save();


                $token = auth()->attempt([
                    'email' => $email,
                    'password' => $password
                ]);
                if (!$token) {
                    $array['error'] = 'Ocorreu um  erro';
                    return $array;
                }
                $info = auth()->user();
                $info['avatar'] = url('media/avatars/' . $info['avatar']);
                $array['data'] = $info;
                $array['token'] = $token;
            } else {
                $array['error'] = 'E-mail já cadastrado';
                return $array;
            }
        } else {
            $array['error'] = 'Dados incorretos';
            return $array;
        }
        return $array;
    }
    /* METODO DE LOGIN */
    public function login(Request $request)
    {
        $array = ['error' => ''];

        $email = $request->input('email');
        $password = $request->input('password');

        $token = auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);
        if (!$token) {
            $array['error'] = 'Usuario ou senha incorretos!';
            return $array;
        }
        $info = auth()->user();
        $info['avatar'] = url('media/avatars/' . $info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;
        return $array;
    }
}
