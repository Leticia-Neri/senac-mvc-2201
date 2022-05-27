<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class APIController extends Controller
{
    public $loginAfterSignUp = true;

    public function login(Request $request){

        $token = null;
        $campos_json = json_decode($request->getContent(), JSON_OBJECT_AS_ARRAY);
        $credenciais = ['email' => $campo_json['email'], 
                        'password' => $campo_json['password']];

        try{
            if(!$token = JWTAuth::attempt($credenciais)){
                return reposnse()->json(['success' => false, 
                                        'message' => 'Credenciais Inválidas'], 401);
            }
        }catch(JWTException $e){
            return response()->json(['error' => 'Token não criado'], 500);
        }
        return respose()->json(['success' => true, 'token' => $token], 200);
    }

}
