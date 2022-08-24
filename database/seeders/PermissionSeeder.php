<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $readSuperCategories = new Permission();
        $readSuperCategories->name = 'Смотреть Суперкатегории';
        $readSuperCategories->slug = 'read-super-categories';
        $readSuperCategories->save();

        $readCategories = new Permission();
        $readCategories->name = 'Смотреть категории';
        $readCategories->slug = 'read-categories';
        $readCategories->save();
    }
}
