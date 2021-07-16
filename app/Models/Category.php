<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    public function courses(){
        return $this->hasMany(Course::class,'category_id');
    }
    public function coursesCount(){
        return Course::where('category_id',$this->id)->count();
    }
    public function setActive($status){
        return $this->update([
            'active'=>$status
        ]);
    }


    //local scopes
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
    public function fullDelete(){
        //check if course has an uploaded image
        if(!str_contains($this->image, 'random')){
            File::delete(public_path($this->image));
            File::deleteDirectory(public_path("category/$this->id/"));
        }
        $this->forceDelete();
    }
}
