<?php
use Illuminate\Database\Seeder;
class ItemGroupSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\ItemGroup::class, 250)->create();
    }
}
