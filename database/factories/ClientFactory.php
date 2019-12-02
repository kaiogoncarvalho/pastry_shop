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


$factory->define(\App\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->name,
        'email'        => $faker->unique()->email,
        'phone'        => $faker->regexify('\d{10,11}'),
        'birthdate'    => $faker->date('Y-m-d', 'now'),
        'address'      => $faker->streetAddress,
        'complement'   => $faker->optional()->sentence,
        'neighborhood' => $faker->word,
        'postcode'     => $faker->regexify('\d{8}'),
    ];
});
