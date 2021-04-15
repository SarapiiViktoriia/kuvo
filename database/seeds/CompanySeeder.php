<?php
use Illuminate\Database\Seeder;
class CompanySeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Company::class,50)->create();
    }
}
