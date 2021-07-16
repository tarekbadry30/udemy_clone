<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'active'    => 1,
        'image'     => 'img/random/'.$faker->randomElement(range(1, 17)).'.jpg'

    ];
});
