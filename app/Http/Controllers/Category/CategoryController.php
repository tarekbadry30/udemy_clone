<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{

    public function all(){
        return view('category.all');
    }

    public function index(){
        return view('category.index');
    }

    public function popular(){
        $list=Category::whereStatus(1)
            ->orderBy('courses_count','desc')->limit(20)->get();
        return $this->returnData('list',$list,'get popular category',200);
    }

    public function categoryList(Request $request){
        $active_status=$request->active_status;
        $delete_status=$request->delete_status;
        $list=Category::whereStatus($active_status)->whereDeleted($delete_status)->orderBy('id','desc')->paginate(env('PAGINATE_NUM',20));
        return $this->returnData('list',$list,'get category list',200);
    }

    public function search(Request $request){
        $status=($request->has('cat_status')&&is_bool($request->cat_status))?$request->cat_status:1;
        $result=Category::where('name', 'LIKE', "%{$request->text}%")->where('active',$status)->get();
        return $this->returnData('list',$result,'search for a category',200);
    }

    public function insert(Request $request){
        $validationRules=[
            'name'=>'required|string|unique:categories',
        ];
        if(isset($request->image))
            $validationRules['image']='required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
            $request->all();
        }else {
            $request->validate($validationRules);
        }
        $category=Category::create([
            'name'=>$request->name,
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image=$this->move_image($file,"category/$category->id/");
            $category->update([
                'image'=>$image
            ]);
        }
        return returnSuccessMessage(translate('createdSuccess'),200);
    }

    public function update(Request $request){
        $validationRules=[
            'category_id'=>'required',
            'name'=>'required|string'
        ];
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
            $request->all();
        }else {
            $request->validate($validationRules);
        }
        $valid=Category::where([
            ['name'     ,$request->name],
            ['id'        ,"!=",$request->category_id],
        ])->first();
        if(isset($valid)){
            return returnErrorMessage(translate('catRepeated'),403);
        }
        $category=Category::find($request->category_id);
        $category->update([
            'name'=>$request->name
        ]);
        if ($request->hasFile('image')) {
            if(!str_contains($category->image, 'random'))
                File::delete(public_path($category->image));
            $file = $request->file('image');
            $image=$this->move_image($file,"category/$category->id/");
            $category->update([
                'image'=>$image
            ]);
        }
        return returnSuccessMessage(translate('updatedSuccess'),200);
    }

    public function changeVisible(Request $request){
        $validationRules=[
            'category_id'     =>'required',
        ];
        if(request_api()){
            $validationError = $this->customValidate($request, $validationRules);
            if(count($validationError)>0)
                return response()->json($validationError);
        }else {
            $request->validate($validationRules);
        }
        $category=Category::withTrashed()->find($request->category_id);
        if(!isset($category))
            return returnErrorMessage(translate('categoryNotFound'),403);
        $category->update([
            'active'    =>  !$category->active,
        ]);
        return $this->returnData('active',$category->active,translate('changeCategoryVisible'),200);
    }

    public function delete(Request $request){
        $validationRules=[
            'category_id'   =>'required',
            'deleteStatus'  =>'required',
        ];

        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);
        $category=Category::withTrashed()->find($request->category_id);
        if(!isset($category))
            return returnErrorMessage(translate('categoryNotFound'),403);
        if($request->deleteStatus=="full")
            $category->fullDelete();
        else
            $category->delete();
        return returnSuccessMessage(translate('deletedSuccess'),200);
    }
    public function restore(Request $request){
        $validationRules=[
            'category_id'     =>'required',
        ];
        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);
        $category=Category::withTrashed()->find($request->category_id);
        if(!isset($category))
            return returnErrorMessage(translate('categoryNotFound'),403);
        $category->restore();
        return returnSuccessMessage(translate('restoredSuccess'),200);
    }

}
