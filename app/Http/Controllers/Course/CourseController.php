<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseRate;
use App\Models\CourseUser;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function all(){
        $data=[];
        $categories=Category::get(['id','name']);
        $data['categories']=$categories;
        return view('courses.all',$data);
    }

    public function index(Request $request){
        if(isset($request->tag_name)){
            $tag=Tag::where('name',$request->tag_name)->first();
            if(!isset($tag))
                return returnErrorMessage(translate('tagNotFound'),403);
            return view('courses.list',['tag'=>$tag]);
        }else{
            $category=Category::findOrFail($request->category_id);
            return view('courses.list',['category'=>$category]);
        }
    }
    public function coursesList(Request $request){
        $active_status=$request->active_status;
        $delete_status=$request->delete_status;
        if(isset($request->tag_name))
            $list=Course::whereStatus($active_status)->whereDeleted($delete_status)->whereTag($request->tag_name)->orderBy('id','desc')->paginate(env('PAGINATE_NUM',20));
        else
            $list=Course::whereStatus($active_status)->whereDeleted($delete_status)->whereCategory($request->category_id)->orderBy('id','desc')->paginate(env('PAGINATE_NUM',20));
        return $this->returnData('list',$list,'get courses list',200);
    }

    public function search(Request $request){
        $active_status=$request->active_status;
        $result=Course::where('name', 'LIKE', "%{$request->text}%")->whereStatus($active_status)->orderBy('id','desc')->get();
        return $this->returnData('list',$result,'search for a course',200);
    }

    public function details(Request $request){
        $validationRules=[
            'course_id'     =>'required',
        ];
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
        }else {
            $request->validate($validationRules);
        }
        $course=Course::find($request->course_id);
        if(!isset($course)){
            return returnErrorMessage(translate('courseNotFound'),403);
        }
        if(!$course->active ){
            if(!get_auth_user()||!get_auth_user()->isAdmin())
                return returnErrorMessage(translate('courseNotAvailableNow'),403);
        }
        $course->increaseViews();

        if(request_api())
            return $this->returnData('course',$course,'get course details',200);
        return view('courses.details',['course'=>$course]);
    }

    public function joinUser(Request $request){
        $validationRules=[
            'course_id'     =>'required',
        ];
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
        }else {
            $request->validate($validationRules);
        }
        $course=Course::find($request->course_id);
        if(!isset($course))
            return returnErrorMessage(translate('courseNotfound'),403);
        if(!$course->active)
            return returnErrorMessage(translate('courseNotAvailableNow'),403);
        $joined=CourseUser::where([
            ['user_id',get_auth_user()->id],
            ['course_id',$course->id],
        ])->first();
        if(isset($joined)){
            $joined->delete();
            $newStatus=false;
        }else{
            CourseUser::create([
                'user_id'       => get_auth_user()->id,
                'course_id'     => $course->id,
            ]);
            $newStatus=true;
        }
        return$this->returnData('newStatus',$newStatus,translate($newStatus?'youAreJoined':'youAreNotJoined'),200);
    }

    public function giveRate(Request $request){
        $validationRules=[
            'course_id'     =>'required',
            'rate'          =>'required|numeric|min:1|max:5',
        ];
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
        }else {
            $request->validate($validationRules);
        }
        $course=Course::find($request->course_id);
        if(!isset($course))
            return returnErrorMessage(translate('courseNotFound'),403);
        if(!$course->active)
            return returnErrorMessage(translate('courseNotAvailableNow'),403);
        $courseRate=CourseRate::firstOrCreate([
            'course_id' =>$course->id,
            'user_id'   =>get_auth_user()->id,
        ]);
        $courseRate->update([
            'rating'    =>  $request->rate,
        ]);
        return $this->returnData('newRate',$course->getRate(),translate('courseRated'),200);
    }

    public function changeVisible(Request $request){
        $validationRules=[
            'course_id'     =>'required',
        ];
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
        }else {
            $request->validate($validationRules);
        }
        $course=Course::withTrashed()->find($request->course_id);
        if(!isset($course))
            return returnErrorMessage(translate('courseNotFound'),403);
        $course->update([
            'active'    =>  !$course->active,
        ]);
        return $this->returnData('active',$course->active,translate('changeCourseVisible'),200);
    }

    public function insert(Request $request){
        $validationRules=[
            'name'          =>'required|string',
            'description'   =>'required|string',
            'hours'         =>'required|numeric',
            'category_id'   =>'required',
            'level'         =>'required|in:beginner,immediate,high',
        ];
        if(isset($request->image))
            $validationRules['image']='required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);

        }else {
            $request->validate($validationRules);
        }
        $course=Course::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'hours'=>$request->hours,
            'category_id'=>$request->category_id,
            'level'=>$request->level,
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image=$this->move_image($file,"courses/$course->id/");
            $course->update([
                'image'=>$image
            ]);
        }
        if ($request->has('tags')) {
            $course->tags()->attach($request->tags);
        }
            return returnSuccessMessage(translate('createdSuccess'),200);
    }

    public function update(Request $request){
        $validationRules=[
            'course_id'     =>'required',
            'category_id'   =>'required',
            'name'          =>'required|string',
            'description'   =>'required|string',
            'hours'         =>'required|numeric',
            'level'         =>'required|in:beginner,immediate,high',
        ];
        if(isset($request->image))
            $validationRules['image']='required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);

        }else {
            $request->validate($validationRules);
        }
        $updateData=[
            'name'          =>$request->name,
            'description'   =>$request->description,
            'hours'         =>$request->hours,
            'category_id'   =>$request->category_id,
            'level'         =>$request->level,
        ];
        $course=Course::find($request->course_id);
        if(!isset($course))
            return returnErrorMessage(translate('courseNotFound'),403);
        if ($request->hasFile('image')) {
            if(!str_contains($course->image, 'random'))
                File::delete(public_path($course->image));
            $file = $request->file('image');
            $image=$this->move_image($file,'courses/'.$course->id.'/');
            $updateData['image']=$image;

        }
        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        }
        $course->update($updateData);
        return returnSuccessMessage(translate('updatedSuccess'),200);
    }

    public function delete(Request $request){
        $validationRules=[
            'course_id'     =>'required',
            'deleteStatus'  =>'required',
        ];

        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);
        $course=Course::withTrashed()->find($request->course_id);
        if(!isset($course))
            return returnErrorMessage(translate('courseNotFound'),403);
        if($request->deleteStatus=="full")
        $course->fullDelete();
        else
            $course->delete();
        return returnSuccessMessage(translate('deletedSuccess'),200);
    }
    public function restore(Request $request){
        $validationRules=[
            'course_id'     =>'required',
        ];
        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);
        $course=Course::withTrashed()->find($request->course_id);
        if(!isset($course))
            return returnErrorMessage(translate('courseNotFound'),403);
            $course->restore();
        return returnSuccessMessage(translate('restoredSuccess'),200);
    }
}
