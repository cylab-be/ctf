<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Set;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {

    $sets = Set::pluck('id')->toArray();

    return [
        "set_id" => $faker->randomElement($sets),
        "name" => $faker->company,
        "statement" => $faker->text(200),
        "flag" => $faker->word,
        "max_submissions" => 3
    ];
});
