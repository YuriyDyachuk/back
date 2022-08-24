<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $soldier = Role::where('slug','soldier')->first();
        $cop = Role::where('slug', 'police-officer')->first();
        $readSuperCategories = Permission::where('slug','read-super-categories')->first();
        $readCategories = Permission::where('slug','read-categories')->first();

        $user1 = new User();
        $user1->name = 'Тест Солдат';
        $user1->email = 'jhon@deo.com';
        $user1->password = bcrypt('secret');
        $user1->type = 0;
        $user1->subscription_type = 0;
        $user1->save();
        $user1->roles()->attach($soldier);
        $user1->permissions()->attach($readSuperCategories);

        $user2 = new User();
        $user2->name = 'Тест коп';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->type = 0;
        $user2->subscription_type = 0;
        $user2->save();
        $user2->roles()->attach($cop);
        $user2->permissions()->attach($readCategories);

        $user3 = new User();
        $user3->name = 'Admin';
        $user3->email = 'admin@gmail.com';
        $user3->password = bcrypt('123123123');
        $user3->type = 0;
        $user3->subscription_type = 0;
        $user3->save();
        $user3->roles()->attach($cop);
        $user3->permissions()->attach($readCategories);

//        User::factory()
//            ->times(50)
//            ->create();
    }
}
