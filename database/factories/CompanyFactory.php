<?php
use Faker\Generator as Faker;
$factory->define(\App\Models\Company::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->text(5),
        'name' => $faker->company(),
        'type' => $faker->randomElement(['supplier', 'consumer', 'both'])
    ];
});
