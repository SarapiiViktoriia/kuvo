<?php
use Faker\Generator as Faker;
$factory->define(\App\Models\Item::class, function (Faker $faker) {
    return [
        'item_group_id' => $faker->numberBetween(1, 50),
        'item_brand_id' => $faker->numberBetween(1, 50),
        'supplier_id'   => $faker->numberBetween(1, 50),
        'name'          => ucwords($faker->unique()->word()),
        'description'   => $faker->paragraph()
    ];
});
