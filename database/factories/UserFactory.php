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
        'login' => $faker->unique()->word,
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'password' => '$2y$10$iRy6c5EiNdblMBWaiMlqPe3wExCGTdx/LRDqzpP3r7JTfSCNUK9gq',
        'session_id' => null,
        'department' => rand(0,6),
        'permission' => rand(0,3)
    ];
});
