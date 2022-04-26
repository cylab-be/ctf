<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Challenge;
use Faker\Generator as Faker;

use Illuminate\Support\Str;

$factory->define(Challenge::class, function (Faker $faker) {
    return [
        "time_start" => time() - 7200,
        "time_end" => time() + 3600,
        "name" => $faker->colorName,
        "code" => Str::random(6)
    ];
});
