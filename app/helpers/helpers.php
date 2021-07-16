<?php

use App\User;
use App\Traits\GeneralTrait;
    function get_auth_user(){
        if(\request()->has("api_token")){
            return $user=User::getUserData(\request()->api_token);
        }
        else if(auth()->check())
            return \auth()->user();
        return false;
    }
    function request_api(){
        if(\request()->has("api_token")||\request()->ajax()||\request()->is('api/*')){
            return true;
        }
        return false;
    }

    function textAlign($real=true){
        if($real)
            return app()->getLocale()=='en'?'text-left':'text-right';
        return app()->getLocale()!='en'?'text-left':'text-right';
    }
    function pageDirection($real=true){
        if($real)
            return app()->getLocale()=='en'?'ltr':'rtl';
        return app()->getLocale()!='en'?'ltr':'rtl';
    }
    function returnErrorMessage($message,$errorNum){
        if(\request()->ajax()||isset(\request()->api_token)||\request()->is('api/*'))
            return response()->json([
                'status'=>false,
                'errorNum'=>$errorNum,
                'msg'=>$message
            ]);
        return response(view("errorMessage",["message"=>$message]));
    }
    function returnErrorMessageValidation($message,$errorNum){
        if(\request()->ajax()||isset(\request()->api_token)||\request()->is('api/*'))
            return response()->json([
                'status'=>false,
                'errorNum'=>$errorNum,
                'msg'=>$message
            ]);
        return response(view("errorMessage",["message"=>$message]));
    }
    function returnSuccessMessage($message,$errorNum){
        if(\request()->ajax()||isset(\request()->api_token)||\request()->is('api/*'))
            return response()->json([
                'status'=>true,
                'errorNum'=>$errorNum,
                'msg'=>$message
            ]);
        return back()->with("success",$message);
    }
    function translate($message){
        return __("frontend.$message");
    }

