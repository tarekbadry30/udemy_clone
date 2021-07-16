<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TagsController extends Controller
{
    public function index(){
        return view('tag.all');
    }

    public function tagsList(){
        $list=Tag::with('courses')->orderBy('name','asc')->paginate(env('PAGINATE_NUM',20));
        return $this->returnData('list',$list,'get tags list',200);
    }

    public function search(Request $request){
        $result=Tag::where('name', 'LIKE', "%{$request->text}%")->get();
        return $this->returnData('list',$result,'search for a tag',200);
    }

    public function insert(Request $request){
        $validationRules=[
            'name'=>'required|string|unique:tags',
        ];
        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);

        Tag::create([
            'name'=>$request->name,
        ]);

        return returnSuccessMessage(translate('createdSuccess'),200);
    }

    public function update(Request $request){
        $validationRules=[
            'tag_id'=>'required',
            'name'  =>'required|string'
        ];
        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);

        $valid=Tag::where([
            ['name'     ,$request->name],
            ['id'        ,"!=",$request->tag_id],
        ])->first();
        if(isset($valid)){
           return returnErrorMessage(translate('nameRepeated'),403);
        }
        Tag::find($request->tag_id)->update([
            'name'=>$request->name
        ]);
        return returnSuccessMessage(translate('updatedSuccess'),200);
    }

    public function delete(Request $request){
        $validationRules=[
            'tag_id'=>'required',
        ];
        $validationError = $this->customValidate($request, $validationRules);
        if(count($validationError)>0)
            return response()->json($validationError);

        Tag::find($request->tag_id)->delete();
        return returnSuccessMessage(translate('deletedSuccess'),200);
    }

}
