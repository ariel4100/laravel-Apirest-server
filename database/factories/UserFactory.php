<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'fullname' => $faker->name,
        'fullsurname' => $faker->lastName,
        'gender' => $faker->randomElement(['hombre','mujer']),
        'email' => $faker->unique()->safeEmail,
        'password' => '2012salvacion', // secret
        'remember_token' => str_random(10),
        'slug' => $faker->slug,
    ];
});

$factory->define(App\Model\Profile::class, function (Faker $faker) {
    return [
        'city' => $faker->city,
        'country' => $faker->country,
        'about' => $faker->sentence(5),
        'image' => $faker->imageUrl(1280, 720),
        'cover-image' => $faker->imageUrl(1280, 720),
    ];
});