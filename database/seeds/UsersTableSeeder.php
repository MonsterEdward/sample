<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'Zhang San';
        $user->email = '1910612833@qq.com';
        $user->password = bcrypt('111111');

        //set this user as admin
        $user->is_admin = true;

        //set activated true
        $user->activated = true;

        $user->save();
    }
}

