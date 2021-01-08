<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'name'         => $faker->unique()->name,
        'age'          => $faker->numberBetween(1, 100),
        'phone_number' => $faker->unique()->numerify('############'),
        'email'        => $faker->unique()->email,
        'major_id'     => function () {
            return factory(App\Major::class)->create()->id;
        },
    ];
});
