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

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->description,
        'price' => 11.0,
        'sku' => '123',
    ];
});

$factory->state(App\Models\User::class, 'invalid', function ($faker) {
    return [
        'name' => '',
        'email' => '',
        'password' => '',
    ];
});
