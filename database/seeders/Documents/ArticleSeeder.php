<?php
declare(strict_types=1);

namespace Database\Seeders\Documents;

use App\Models\Documents\Article;
use App\Models\Documents\Section;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Section::all()->each(function (Section $section) {
            Article::factory()
                ->times(3)
                ->create([
                    $section->articles()->getForeignKeyName() => $section,
                ]);
        });
    }
}
