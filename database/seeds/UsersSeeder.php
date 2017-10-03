<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');
        $admin = new Role;
        $admin->name = 'admin';
        $admin->display_name = 'Admin';
        $admin->save();

        // super admin
        $user = new User;
        $user->name = 'Super Admin';
        $user->phone = '087880228394';
        $user->username = 'admin';
        $user->email = 'aryapujianto@inarts.co.id';
        $user->password = bcrypt('inarts2017!');
        $user->save();
        $user->attachRole($admin);

        // foreach (range(1, 16) as $index) {
        //     $user = new User;
        //     $user->name = $faker->name;
        //     $user->username = 'admin'.$index;
        // 	$user->phone = $faker->e164PhoneNumber;
        //     $user->email = $faker->email;
        //     $user->password = bcrypt('telkomsel123!');
        //
        //     $user->save();
        //     $user->attachRole($admin);
        // }
    }
}
