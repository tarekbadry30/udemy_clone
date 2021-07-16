<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $guarded =[];
    public function courses(){
        return $this->belongsToMany(Course::class,'course_tags','tag_id','course_id');
    }
}
