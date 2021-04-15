<?php
use Illuminate\Database\Seeder;
class ItemSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Item::class, 100)->create();
    }
}
