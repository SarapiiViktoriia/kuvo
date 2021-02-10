<?php
use App\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $new_role = new Profile([
            'name' => 'System Administrator',
        ]);
        $new_role->save();
        $new_user = new User([
            'profile_id' => 1,
        	'name'       => 'System Administrator',
        	'email'      => 'admin@admin.com',
        	'username'   => 'admin',
        	'password'   => bcrypt('password'),
        ]);
        $new_user->save();
    }
}
