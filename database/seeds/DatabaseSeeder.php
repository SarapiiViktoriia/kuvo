<?php
use App\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $new_user = new User([
        	'name' => 'System Administrator',
        	'email' => 'admin@admin.com',
        	'username' => 'admin',
        	'password' => bcrypt('password'),
        ]);
        $new_user->save();
    }
}
