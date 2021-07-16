<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CourseView extends Model
{
    protected $guarded =[];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

}
