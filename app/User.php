<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','api_token','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //change account type from bool to string
    public function getTypeAttribute($val){
        if ($val==1)
            return 'admin';
        return 'user';
    }
    public function typeIs($type){
        if($this->type==$type)
            return true;
        return false;
    }
    public function isAdmin(){
        if($this->type=='admin'||$this->type==1)
            return true;
        return false;
    }
    public function getApiToken($generateNew=false){
        if($generateNew||!isset($this->api_token)){
            $this->api_token=Str::random(150);
            $this->save();
        }
        return $this->api_token;
    }
    public static function getUserData($api_token){
        return User::where("api_token",$api_token)->first();
    }

}
