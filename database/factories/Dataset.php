<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dataset;
use Faker\Generator as Faker;

$factory->define(Dataset::class, function (Faker $faker) {
    $gender=['male', 'female', 'other'];
    $education = ['Madhayamic', 'HS', 'Graduate'];
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        // 'gender' => $gender[rand(0,2)],
        'age' => rand(10, 60),
        'dob' => $faker->date(),
        // 'address' => $faker->address(),
        // 'education' => $education[rand(0,2)],
        // Burdwan bound box
        'lat' => $faker->latitude(22.9025091, 22.858279),
        'lng' => $faker->longitude(87.756510, 87.814149),
        // 'alt' => $faker->randomFloat(2, 20, 30),
    ];
});
