<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use App\Client;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    $users = Client::all()->pluck('id')->toArray();
    $fakeDateTime=$faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);
    return [
        'amount'=>$faker->randomNumber(rand(2,6)),
        'user_id'=>$faker->randomElement($users),
        'created_at' => $fakeDateTime,
        'updated_at' => $fakeDateTime
    ];
});
