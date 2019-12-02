<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(\App\Models\Pastry::class, function (Faker\Generator $faker) {
    $nameImage = $faker->word().".jpg";
    return [
        'name'  => $faker->name,
        'price' => $faker->regexify('\d{1,8}\.\d{0,2}'),
        'photo' => $nameImage
    ];
});
