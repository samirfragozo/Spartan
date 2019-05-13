<?php

/** @var Factory $factory */

use App\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'remember_token' => Str::random(10),
        'model_type' => null,
        'model_id' => null,
    ];
});
