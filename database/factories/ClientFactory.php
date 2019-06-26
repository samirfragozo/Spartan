<?php

/* @var $factory Factory */

use App\Client;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => "{$faker->firstName} {$faker->lastName} {$faker->lastName}",
        'rfid' => null,
        'end' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 year'),
    ];
});
