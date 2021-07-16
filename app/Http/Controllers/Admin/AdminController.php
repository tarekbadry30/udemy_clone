<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        $data=[];
        $data['categoryCount']=Category::count();
        $data['coursesCount']=Course::count();
        $data['tagsCount']=Tag::count();
        return view('admin.dashboard',$data);
    }
}
