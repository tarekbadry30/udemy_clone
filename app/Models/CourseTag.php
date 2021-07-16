<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model
{
    protected $guarded =[];
    public function tag(){
        return $this->belongsTo(Tag::class,'tag_id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

}
