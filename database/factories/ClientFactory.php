<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;
 
$factory->define(Client::class, function (Faker $faker) {
    
    $fakeDateTime=$faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'created_at' => $fakeDateTime,
        'updated_at' => $fakeDateTime
    ];
});
