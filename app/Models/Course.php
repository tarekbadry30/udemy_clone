<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Course extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'course_users','course_id','user_id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class,'course_tags','course_id','tag_id');
    }
    public function scopeWhereStatus($query,$val){
        if(isset($val))
            return $query->where('active',$val);
        return $query->where('active',1);
    }
    public function scopeWhereDeleted($query,$val){
        if(isset($val))
            return $query->onlyTrashed();
        return $query;
    }
    public function scopeWhereTag($query,$val){
        $coursesIDS=CourseTag::where('tag_id',Tag::where('name',$val)->first()->id)->pluck('course_id');
        return $query->whereIn('id',$coursesIDS);
    }
    public function scopeWhereCategory($query,$val){
        if(isset($val))
            return $query->where('category_id',$val);
        return $query;
    }

    //mutators
    public function getRate(){
        return collect(CourseRate::where('course_id',$this->id)->pluck('rating'))->avg();
    }

    public function getStudentStatus(){
        if(!auth()->check())
            return false;
        $joined= CourseUser::where([
            ['course_id',$this->id],
            ['user_id',get_auth_user()->id],
        ])->first();
        if(isset($joined))
            return true;
        return false;
    }


    // custom functions
    public function increaseViews(){
        if(get_auth_user() && !get_auth_user()->isAdmin()){
            $visited= CourseView::where([
                ['course_id' , $this->id],
                ['user_id'   , get_auth_user()->id],
            ])->first();
            if(!isset($visited)){
                return CourseView::create([
                    'course_id' => $this->id,
                    'user_id'   => get_auth_user()->id,
                ]);
                $this->views++;
            }
        }
    }
    public function fullDelete(){
        //check if course has an uploaded image
        if(!str_contains($this->image, 'random')){
            File::delete(public_path($this->image));
            File::deleteDirectory(public_path("courses/$this->id/"));
        }
        $this->forceDelete();
    }
}
