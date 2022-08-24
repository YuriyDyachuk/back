<?php
declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Categories\CategorySeeder;
use Database\Seeders\Categories\SuperCategorySeeder;
use Database\Seeders\Documents\ArticleSeeder;
use Database\Seeders\Documents\DocumentSeeder;
use Database\Seeders\Documents\SectionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SuperCategorySeeder::class,
            CategorySeeder::class,
            DocumentSeeder::class,
            SectionSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
