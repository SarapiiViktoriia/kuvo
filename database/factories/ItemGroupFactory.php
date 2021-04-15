<?php
use Faker\Generator as Faker;
$factory->define(\App\Models\ItemGroup::class, function (Faker $faker) {
    return [
        'name'        => ucfirst($faker->word()),
        'description' => $faker->paragraph(),
    ];
});
