<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
     \Illuminate\Support\Facades\Artisan::all('config:clear');
     \Illuminate\Support\Facades\Artisan::all('cache:clear');
     \Illuminate\Support\Facades\Artisan::all('view:clear');
     return 'all cleared';
});
Route::get('/', function () {
    return view('courses.index');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(["prefix"=>"admin",'middleware'=>['auth','AdminAccount'],'as' => 'admin.'], function() {
    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');
});

Route::group(["prefix"=>"category",'as' => 'category.'], function() {
    Route::get('/all', 'Category\CategoryController@all')->name('all')->middleware('AdminAccount');
    Route::get('/list', 'Category\CategoryController@index')->name('list');
    Route::post('/popular', 'Category\CategoryController@popular')->name('popular');
    Route::post('/list', 'Category\CategoryController@categoryList')->name('listAjax');
    Route::post('/change-visible', 'Category\CategoryController@changeVisible')->name('changeVisible')->middleware('AdminAccount');
    Route::post('/insert', 'Category\CategoryController@insert')->name('insert')->middleware('AdminAccount');
    Route::post('/update', 'Category\CategoryController@update')->name('update')->middleware('AdminAccount');
    Route::post('/delete', 'Category\CategoryController@delete')->name('delete')->middleware('AdminAccount');
    Route::post('/restore', 'Category\CategoryController@restore')->name('restore')->middleware('AdminAccount');

});

Route::group(["prefix"=>"courses",'as' => 'courses.'], function() {
    Route::get('/all', 'Course\CourseController@all')->middleware('AdminAccount')->name('all');
    Route::get('/list', 'Course\CourseController@index')->name('list');
    Route::get('/tag', 'Course\CourseController@coursesList')->name('tag');
    Route::match(['get','post'],'/details', 'Course\CourseController@details')->name('details');
    Route::post('/join', 'Course\CourseController@joinUser')->name('join')->middleware('auth');
    Route::post('/change-visible', 'Course\CourseController@changeVisible')->name('changeVisible')->middleware(['auth','AdminAccount']);
    Route::post('/give-rate', 'Course\CourseController@giveRate')->name('giveRate')->middleware('auth');
    Route::post('/search', 'Course\CourseController@search')->name('search');
    Route::post('/list-ajax', 'Course\CourseController@coursesList')->name('listAjax');
    Route::post('/insert', 'Course\CourseController@insert')->name('insert')->middleware(['auth','AdminAccount']);
    Route::post('/update', 'Course\CourseController@update')->name('update')->middleware(['auth','AdminAccount']);
    Route::post('/delete', 'Course\CourseController@delete')->name('delete')->middleware(['auth','AdminAccount']);
    Route::post('/restore', 'Course\CourseController@restore')->name('restore')->middleware(['auth','AdminAccount']);
});

Route::group(["prefix"=>"tags",'as' => 'tags.'], function() {
    Route::get('/list', 'Tags\TagsController@index')->name('list')->middleware(['auth','AdminAccount']);
    Route::post('/search', 'Tags\TagsController@search')->name('search');
    Route::post('/list-ajax', 'Tags\TagsController@tagsList')->name('listAjax');
    Route::post('/insert', 'Tags\TagsController@insert')->name('insert')->middleware(['auth','AdminAccount']);
    Route::post('/update', 'Tags\TagsController@update')->name('update')->middleware(['auth','AdminAccount']);
    Route::post('/delete', 'Tags\TagsController@delete')->name('delete')->middleware(['auth','AdminAccount']);
});
