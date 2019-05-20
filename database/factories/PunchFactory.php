<?php

/* @var $factory Factory */

use App\Punch;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Punch::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = '-1 day'),
        'client_id' => function () {
            return factory(App\Client::class)->create()->id;
        },
        'access_id' => 1,
    ];
});
