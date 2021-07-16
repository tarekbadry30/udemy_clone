<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name'          =>$faker->name,
        'description'   =>$faker->text,
        'hours'         =>rand(1,80),
        'category_id'   =>\App\Models\Category::orderByRaw('RAND()')->first()->id,
        'level'         =>$faker->randomElement(['beginner','immediate', 'high']),
        'image'         =>'img/random/'.$faker->randomElement(range(1, 17)).'.jpg'
    ];
});
