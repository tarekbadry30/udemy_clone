<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('AuthAPI:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\AuthControllerAPI@login');
Route::post('/register', 'API\AuthControllerAPI@register');

Route::group(["prefix"=>"category",'as' => 'category.'], function() {
    Route::post('/search', 'Category\CategoryController@search');
    Route::post('/popular', 'Category\CategoryController@popular');
    Route::post('/list', 'Category\CategoryController@categoryList');
});

Route::group(["prefix"=>"courses",'as' => 'courses.'], function() {
    Route::post('/list', 'Course\CourseController@coursesList');
    Route::post('/search', 'Course\CourseController@search');

    Route::post('/details', 'Course\CourseController@details');
    Route::post('/join', 'Course\CourseController@joinUser')->middleware('AuthAPI');
    Route::post('/give-rate', 'Course\CourseController@giveRate')->middleware('AuthAPI');
});

Route::group(["prefix"=>"tags",'as' => 'tags.'], function() {
    Route::post('/search', 'Tags\TagsController@search');
    Route::post('/list', 'Tags\TagsController@tagsList');
});
