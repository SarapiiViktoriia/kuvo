<?php
use Faker\Generator as Faker;
$factory->define(\App\Models\ItemBrand::class, function (Faker $faker) {
    return [
        'name'        => ucwords($faker->unique()->sentence(2, true)),
        'description' => $faker->paragraph(),
    ];
});
