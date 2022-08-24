<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Полицейский';
        $manager->slug = 'police-officer';
        $manager->save();
        $developer = new Role();
        $developer->name = 'Солдат';
        $developer->slug = 'soldier';
        $developer->save();
    }
}
