<?php
use Illuminate\Database\Seeder;
class ItemBrandSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\ItemBrand::class, 350)->create();
    }
}
