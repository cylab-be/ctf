<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Set;
use Faker\Generator as Faker;

$factory->define(Set::class, function (Faker $faker) {
    return [
        "name" => $faker->company,
        "user_id" => 1, // admin
        "description" => $faker->text(100),
        "comment" => $faker->streetName
    ];
});
