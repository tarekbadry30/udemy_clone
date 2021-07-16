<?php

use Illuminate\Database\Seeder;

class setupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'              =>'admin',
            'email'             =>'admin@admin.com',
            'password'          =>\Illuminate\Support\Facades\Hash::make('12345678'),
            'type'              =>1,
            'email_verified_at' =>now()
        ]);
        $tags=['html','css','js','jq','php','mysql','laravel','c++','c#','ruby','vue.js','angular.js','react.js','ASP.net','Java','Kotlin','flutter'];
        foreach ($tags as $tag)
        \App\Models\Tag::create([
            'name'=>$tag
        ]);
        factory(\App\Models\Category::class,30)->create();
        factory(\App\Models\Course::class,180)->create()->each(function ($u){
            //generate random tags for each course
            $u->tags()->attach(range(1,rand(1,17)));
        });
    }
}
