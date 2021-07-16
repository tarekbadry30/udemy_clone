<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthControllerAPI extends Controller
{
    public function login(Request $request){
        $email = $request->get('email');
        $password = $request->get('password');
        $user = User::where('email', $email)->first();
        if (!isset($user))
            return returnErrorMessage('login failed',403);
        if (!Hash::check($password, $user->password))
            return returnErrorMessage('login failed',403);
        $user->getApiToken();
        $user->makeVisible('api_token');
        return $this->returnData('user',$user,'login success welcome back',200);
    }

    public function register(Request $request){
        $validationRules=[
            'name'      =>'required|string|min:3',
            'email'     =>'required|email|unique:users',
            'password'  =>'required|string|min:8|confirmed',
        ];
        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);
        User::create([
            'name'      =>$request->name,
            'email'     =>$request->email,
            'password'  =>Hash::make($request->password),
        ]);
        return returnSuccessMessage('user account created you can login now',200);

    }

}
